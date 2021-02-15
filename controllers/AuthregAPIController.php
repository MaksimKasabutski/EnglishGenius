<?php
require_once ROOT . '/models/Users.php';
require_once ROOT . '/components/Security.php';
require_once ROOT . '/components/Response.php';

class AuthregAPIController
{
    public function actionLogin()
    {
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
    }

    public function actionRegistration()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        $username = strip_tags(trim($request['username']));
        $password = strip_tags(trim($request['password']));
        $passwordConf = strip_tags(trim($request['passwordConf']));
        $email = strip_tags(trim($request['email']));


        if (Users::isUsernameUsed($username)) {
            $response = new Response('error', 'Пользователь с таким именем уже существует');
        } elseif (!Users::checkUserName($username)) {
            $response = new Response('error', 'Неверный формат имени');
        } elseif (!Service::checkLength(8, 60, $password)) {
            $response = new Response('error', 'Wrong password length');
        } elseif (Users::isEmailUsed($email)) {
            $response = new Response('error', 'Пользователь с таким Email уже существует');
        } elseif ($password != $passwordConf) {
            $response = new Response('error', 'Ошибка. Пароли не совпадают.');
        } elseif (!preg_match("/^\w+([\.\w]+)*\w@\w((\.\w)*\w+)*\.\w{2,3}$/", $email)) {
            $response = new Response('error', 'Ошибка. Неверный формат почтового адреса.');
        } else {
            $hash = Security::encodePassword($password);
            if (Users::addUser($username, $email, $hash)) {
                setcookie("hash", '', strtotime('+30 days')); //1 month
                $_SESSION['userid'] = Users::getUserId($username);
                $_SESSION['username'] = $username;
                $response = new Response('success', 'Регистрация прошла успешно.');
            } else $response = new Response('error', 'Something went wrong.');
        }

        echo json_encode($response);
    }
}