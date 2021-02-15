<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/core/bootstrap.php');

if ($_SERVER['REQUEST_URI'] == '/') {
    header('Location: profile');
}
$router = new Router();
$router->run();