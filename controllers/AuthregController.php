<?php
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/components/Response.php';
require_once ROOT . '/models/Profile.php';
require_once ROOT . '/models/Users.php';


class AuthregController extends Controller
{

    public function actionLogin()
    {
        if (!Users::isAlreadyLogin()) {
            $this->view->generate('login.php', 'authregTemplate.php');
        } else {
            header('Location: profile');
        }
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
        if (!Users::isAlreadyLogin()) {
            $this->view->generate('registration.php', 'authregTemplate.php');
        } else {
            header('Location: profile');
        }
    }
}