<?php


namespace App\Classes;


class Config {

    public static function get($path = null) {
        if ($path) {

            switch ($_SERVER[ 'SERVER_NAME' ]):
                case 'local':
                    $config = $GLOBALS[ 'config' ][ 'env' ][ 'local' ];
                    break;

                case 'website.com':
                    $config = $GLOBALS[ 'config' ][ 'env' ][ 'production' ];
                    break;

                default:
                    $config = null;
                    break;
            endswitch;


            $path = explode('/', $path);

            foreach ($path as $bit) {
                if (isset( $config[ $bit ] )) {
                    $config = $config[ $bit ];
                }
            }

            return $config;
        }

        return false;
    }
}