<?php

namespace App\Classes;

class Auth {
    private $isLogged = false;
    private $crud = null;

    public function __construct(Crud $crud) {
        $this->crud = $crud;
        if (Session::exists('user')) {
            $us = Session::get('user');
            $this->crud->find($us[ 'id' ]);
            $this->isLogged = true;

        }
    }

    public function login($email = null, $password = null, $remember = false) {
        //sleep(2);

        if (( $email === null || $password === null ) && Session::exists('user')) {
            $us = Session::get('user');
            $this->crud->find($us[ 'id' ]);
            $this->isLogged = true;

            return $this->isLogged;
        }

        $user = $this->crud->first(array (
            'email'    => $email,
//            'password' => $password // Hash::encrypt($password)
            'password' => Hash::encryptIt($password)
        ));

        if ($user && count($user) > 0) {
            if (!$user[ 'is_active' ]) die( "<span style='color:red;'>Votre compte n'est pas activ&eacute;, veuillez contacter l'administrateur</span><br/>Cliquer <a href='login.php'>ici</a> pour se connecter avec un autre compte" );

            $this->isLogged = true;
            $session = $user;
            if (isset( $session[ 'password' ] )) unset( $session[ 'password' ] );
            Session::put('user', $session);

            if ($remember === true) {
                $hash = Hash::unique();
                $hashCheck = $this->crud->selectFirstFromOtherTable('sessions', 'user_id=:user_id', array ( 'user_id' => $user[ 'id' ] ));
                if ($hashCheck !== null && count($hashCheck) > 0) {
                    $this->crud->updateOtherTable('sessions', array ( 'hash' => $hash ), 'user_id=:user_id', array ( 'user_id' => $user[ 'id' ] ));
                } else {
                    $this->crud->insertIntoOtherTable('sessions', array (
                        'user_id' => $user[ 'id' ],
                        'hash'    => $hash
                    ));
                }
                Cookie::put('hash', $hash);
            }
        }

        return $this->isLogged;
    }

    public function isLogged() {
        return $this->isLogged || $this->checkHash(Cookie::get('hash'));
    }

    public function logout() {
        $us = Session::get('user');
        if ($this->isLogged()) $this->crud->deleteFromOtherTable('sessions', 'user_id=:user_id', array ( 'user_id' => $us[ 'id' ] ));
        $this->isLogged = false;
        Cookie::delete('hash');
        Session::delete('user');
    }

    public function getRandomKey($length = 20) {
        $chars = "A1B2C3D4E5F6G7H8I9J0K1L2M3N4O5P6Q7R8S9T0U1V2W3X4Y5Z6a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6";
        $key = "";

        for ($i = 0; $i < $length; $i++) {
            $key .= $chars{mt_rand(0, strlen($chars) - 1)};
        }

        return $key;
    }

    public function checkHash($hash) {
        $result = $this->crud->selectFirstFromOtherTable('sessions', 'hash=:hash', array ( 'hash' => $hash ));

        return ( $result && count($result) > 0 ) ? true : false;
    }
}
