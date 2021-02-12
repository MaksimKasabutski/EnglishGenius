<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));
require_once(ROOT . '/components/Router.php');

if ($_SERVER['REQUEST_URI'] == '/profile') {
    $title = $_SESSION['username'];
} else $title = 'EnglishGenius';

?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="library/hystModal-master/dist/hystmodal.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css"
          integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
            crossorigin="anonymous"></script>
</head>
<body>

<?php

$router = new Router();
$router->run();

?>


<script src="library/hystModal-master/dist/hystmodal.min.js"></script>
</body>
</html>