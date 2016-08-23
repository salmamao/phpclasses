<?php

namespace App\Classes;

class Table {
    private $bdd = null;
    protected $columns = null;
    protected $table = null;

    public function __construct(DataBase $bdd) {
        $this->bdd = $bdd;
        $this->columns = array ();
    }

    public function setTableName($table = '') {
        $this->table = $table;
    }


    public function addColumn($column = '', $type = '', $more = '') {
        $this->columns[] = array ( 'column' => $column, 'type' => $type, 'more' => $more );
    }

    public function dropTable() {
        $sql = '';
        $sql .= 'DROP TABLE IF  EXISTS ' . $this->table;

        return $this->bdd->run($sql);
    }

    public function dropColumn($column) {
        $sql = '';
        $sql .= 'ALTER TABLE ' . $this->table . ' DROP COLUMN ' . $column;

        return $this->bdd->run($sql);
    }

    public function create() {
        $sql = '';
        $sql .= 'CREATE TABLE IF NOT EXISTS ' . $this->table . ' ( ';
        $i = 0;
        foreach ($this->columns as $column) {
            if ($i != 0) $sql .= ', ';
            $sql .= ' ' . $column[ 'column' ] . ' ' . $column[ 'type' ] . ' ' . $column[ 'more' ] . ' ';
            $i++;
        }
        $sql .= ' ) ';

        return $this->bdd->run($sql);
    }
}