<?php
namespace App\Classes;

class Zipper {
    private $_files = array ();
    private $_zip;

    public function __construct() {
        $this->_zip = new ZipArchive();
    }

    public function add($input = null) {
        if ($input) {
            if ($input && is_array($input)) {
                $this->_files = array_merge($this->_files, $input);
            } else {
                $this->_files[] = $input;
            }
        }
    }

    public function filterFiles() {
        if (count($this->_files)) {
            if ($this->_files) foreach ($this->_files as $index => $file) {
                if (is_dir($file)) {
                    $files = new RecursiveIteratorIterator (new RecursiveDirectoryIterator($file), RecursiveIteratorIterator::LEAVES_ONLY);
                    if ($files) foreach ($files as $name => $f) {

                        if (preg_match("/\.$/", $f)) continue;

                        $filePath = $f->getPathName();
                        $this->_files[] = $filePath;
                    }
                    unset( $this->_files[ $index ] );
                }
            }
        }
    }

    public function store($location = null) {

        $this->filterFiles();

        if (count($this->_files) && $location) {
            if ($this->_files) foreach ($this->_files as $index => $file) {
                if (!file_exists($file)) {
                    unset( $this->_files[ $index ] );
                }
            }

            if ($this->_zip->open($location, file_exists($location) ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE)) {

                $index = 1;

                Session::start();

                if ($this->_files) foreach ($this->_files as $key => $file) {
                    //sleep(1);
                    $_SESSION[ 'downloadstatus' ] = array ( "status" => "pending", "message" => $index++ );
                    session_write_close();
                    $this->_zip->addFile($file, $file);
                    session_start();
                }
                $_SESSION[ 'downloadstatus' ] = array ( "status" => "finished", "message" => "Done" );
                if (!$this->_zip->close()) return false;
                else return true;
            } else return false;
        } else return false;
    }

    public function show() {
        echo '<pre>';
        print_r($this->_files);
        echo '</pre>';
    }
}