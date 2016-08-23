<?php

namespace App\Classes;

class Util {
    public static function preprint($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

    public static function preprintdie($array) {
        static::preprint($array);
        die();
    }

    public static function FormatDateYMDtoDMY($date) {
        if ($date !== null) {
            return \DateTime::createFromFormat("Y-m-d H:i:s", $date)->format("d/m/Y");
        }

        return date("d/m/Y");
    }

    public static function FormatDateYMDtoDMYHIS($date) {
        if ($date !== null) {
            return \DateTime::createFromFormat("Y-m-d H:i:s", $date)->format("d/m/Y H:i:s");
        }

        return date("d/m/Y H:i:s");
    }

    public static function get_url_contents($url) {
        $crl = curl_init();
        $timeout = 5;
        curl_setopt($crl, CURLOPT_URL, $url);
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
        $ret = curl_exec($crl);
        curl_close($crl);

        return $ret;
    }

    public static function getHtml($url, $post = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if (!empty( $post )) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public static function remove_accents($str, $charset = 'utf-8') {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);

        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
        $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

        return $str;
    }

    public static function url_get_contents($url, $useragent = 'cURL', $headers = false, $follow_redirects = false, $debug = false) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($headers == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
        }

        if ($headers == 'headers only') {
            curl_setopt($ch, CURLOPT_NOBODY, 1);
        }

        if ($follow_redirects == true) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        }

        if ($debug == true) {
            $result[ 'contents' ] = curl_exec($ch);
            $result[ 'info' ] = curl_getinfo($ch);
        } else $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public static function getXML($url = '') {
        return new SimpleXMLElement(file_get_contents($url));
    }
}
