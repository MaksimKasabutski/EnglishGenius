<?php
    if(session_status() != PHP_SESSION_ACTIVE) session_start();     
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    

    require_once('Response.php');
    require_once('UserProvider.php');
    require_once('Security.php');


    $request = json_decode(file_get_contents('php://input'), true);
    
    $username = strip_tags(trim( $request['username'] ));
    $password = strip_tags(trim( $request['password'] ));

    if (!UserProvider::getUser($username)) {
        $response = new Response('error', 'Такой пользователь не найден.');
    } else {
        if (Security::checkPassword($username, $password)) {
            $cookie = Security::generateRandomString(15);
            UserProvider::addCookieToUser($username, $cookie);
            setcookie("hash", $cookie, time()+60*60*24*30);
            $_SESSION['userid'] = UserProvider::getUserId($username);
            $_SESSION['username'] = $username;
            $response = new Response('success', 'Hello, '.$username);
        } else {
            $response = new Response('error', 'Неверный пароль');
        }
    }
    
    echo json_encode($response);
    return;