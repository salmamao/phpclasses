<?php

namespace App\Classes;

define("PREE", "3Xr&");//Sel
define("POSTT", "L;8`");

class Hash {
    public static function make($string, $salt = '') {
        return hash('sha256', $string . $salt);
    }

    public static function salt($length = null) {
        //return mcrypt_create_iv($length);
        return md5(uniqid());
    }

    public static function unique() {
        return self::make(uniqid());
    }

    public static function encryptIt($q) {
        $cryptKey = 'LojfLd9dgkq5iK5Poeir89';
        $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));

        return ( $qEncoded );
    }

    public static function decryptIt($q) {
        $cryptKey = 'LojfLd9dgkq5iK5Poeir89';
        $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");

        return ( $qDecoded );
    }
}