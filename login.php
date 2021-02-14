<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

define('ROOT', dirname(__FILE__));
require_once ROOT . '/components/Response.php';
require_once ROOT . '/models/Users.php';

$request = json_decode(file_get_contents('php://input'), true);

$username = strip_tags(trim($request['username']));
$password = strip_tags(trim($request['password']));

if (!Users::isUsernameUsed($username)) {
    $response = new Response('error', 'Такой пользователь не найден.');
} else {
    if (Security::checkPassword($username, $password)) {
        setcookie("hash", '', strtotime( '+30 days' ));
        $_SESSION['userid'] = Users::getUserId($username);
        $_SESSION['username'] = $username;
        $response = new Response('success', 'Hello, ' . $username);
    } else {
        $response = new Response('error', 'Неверный пароль');
    }
}

echo json_encode($response);
return;