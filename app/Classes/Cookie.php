<?php

namespace App\Classes;

class Cookie {
    public static function exists($name) {
        return ( isset( $_COOKIE[ strval($name) ] ) ) ? true : false;
    }

    public static function get($name) {
        return ( isset( $_COOKIE[ strval($name) ] ) ) ? $_COOKIE[ strval($name) ] : null;
    }

    public static function put($name, $value, $expiry = 2592000) {
        if (setcookie(strval($name), $value, time() + intval($expiry), '/', null, false, true)) {
            return true;
        }

        return false;
    }

    public static function delete($name) {
        self::put($name, '', -36000);
    }
}