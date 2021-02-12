<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Router.php');

if($_SERVER['REQUEST_URI'] == '/profile')
{
    $title = $_SESSION['username'];
} else $title = 'EnglishGenius';

?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <title><?= $title?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="library/hystModal-master/dist/hystmodal.min.css">
</head>
<body>

<?php

$router = new Router();
$router->run();

?>


<script src="library/hystModal-master/dist/hystmodal.min.js"></script>
</body>
</html>