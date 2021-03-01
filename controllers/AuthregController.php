<?php

namespace Controllers;

use Core\Controller;
use Core\View;
use Models\Users;

class AuthregController extends Controller
{
    public function __construct()
    {
        if (Users::isAlreadyLogin()) {
            header('Location: profile');
        }
        $this->view = new View();
    }

    public function actionLogin()
    {
        $this->view->generate('login.php', 'authregTemplate.php');
    }

    public function actionLogout()
    {
        $_SESSION = [];
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
            setcookie("hash", '', time() - 60 * 60 * 24 * 30, '/');
        }
        session_destroy();
        header('Location: login');
    }

    public function actionRegistration()
    {
        $this->view->generate('registration.php', 'authregTemplate.php');
    }

    public function actionReset()
    {
        $this->view->generate('reset.php', 'authregTemplate.php');
    }

    public function actionNewpass($parameters)
    {
        $this->view->generate('newpass.php', 'authregTemplate.php', $parameters);
    }
}