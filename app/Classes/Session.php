<?php

namespace App\Classes;

class Session {

    public static function start() {
//        $status = session_status();
//        if ($status == PHP_SESSION_NONE) {//There is no active session
//            session_start();
//        } else if ($status == PHP_SESSION_DISABLED) {//Sessions are not available
//
//        } else if ($status == PHP_SESSION_ACTIVE) {//Destroy current and start new one
//            //session_destroy();
//            //session_start();
//        }
//        if(session_id() == '') session_start();
        if (!isset( $_SESSION )) session_start();
    }

    public static function exists($name) {
        static::start();

        return ( isset( $_SESSION[ strval($name) ] ) ) ? true : false;
    }

    public static function get($name) {
        static::start();

        return self::exists($name) ? $_SESSION[ strval($name) ] : null;
    }

    public static function put($name, $value) {
        static::start();

        return $_SESSION[ strval($name) ] = $value;
    }

    public static function delete($name) {
        static::start();
        if (self::exists($name)) {
            unset( $_SESSION[ strval($name) ] );
        }
    }

    public static function destroy() {
        static::start();
        if (isset( $_SESSION )) {
            session_destroy();
            $_SESSION = array ();
        }
    }

    public static function flash($name, $string = '') {
        static::start();
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);

            return $session;
        } else {
            self::put($name, $string);

            return null;
        }
    }
}