<?php
require 'config.php';
use Core\Router;

require 'core/bootstrap.php';

//if ($_SERVER['REQUEST_URI'] == '/') {
//    header('Location: profile');
//}
$router = new Router();
$router->run();