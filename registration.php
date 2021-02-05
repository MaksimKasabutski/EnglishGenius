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
    $passwordConf = strip_tags(trim( $request['passwordConf'] ));
    $email = strip_tags(trim( $request['email'] ));
    
    
    if (UserProvider::getUser($username)) {
        $response = new Response('error', 'Пользователь с таким именем уже существует');
    } elseif (!UserProvider::checkUserName($username)) {
        $response = new Response('error', 'Неверный формат имени');
    } elseif ( UserProvider::isEmailUsed($email) ) {
        $response = new Response('error', 'Пользователь с таким Email уже существует');
    } elseif ( $password != $passwordConf ) {
        $response = new Response('error', 'Ошибка. Пароли не совпадают.');
    } elseif ( !preg_match("/^\w+([\.\w]+)*\w@\w((\.\w)*\w+)*\.\w{2,3}$/", $email) ) {
        $response = new Response('error', 'Ошибка. Неверный формат почтового адреса.');
    } else {
        $hash = Security::encodePassword($password);
        $cookie = Security::generateRandomString(15);
        if(UserProvider::addUser($username, $email, $hash, $cookie)) {
            setcookie("hash", $cookie, time()+60*60*24*30); //1 month
            $_SESSION['userid'] = UserProvider::getUserId($username);
            $_SESSION['username'] = $username;
            $response = new Response('success', 'Регистрация прошла успешно.');
        } else $response = new Response('error', 'Something went wrong.');
    }

    echo json_encode($response);
    return;