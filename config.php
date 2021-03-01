<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

//DB config
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '1234');
define('DBNAME', 'EnglishGenius');

define('URL', 'http://englishgenius.loc/');
define('ROOT', dirname(__FILE__));