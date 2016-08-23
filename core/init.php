<?php
include_once __DIR__ . '/../vendor/autoload.php';

use App\Classes\DataBase;
use App\Classes\Config;
use App\Classes\Session;

Session::start();

$GLOBALS[ 'config' ] = include __DIR__ . '/../config/app.php';


$bdd = new DataBase('mysql:host=' . Config::get('database/host') . ';dbname=' . Config::get('database/database') . ';charset=' . Config::get('database/charset'), Config::get('database/username'), Config::get('database/password'));
function getError($error) { echo $error; }

$bdd->setErrorCallbackFunction('getError');