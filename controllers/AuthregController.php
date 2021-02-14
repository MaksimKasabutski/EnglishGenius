<?php
include_once ROOT . '/models/Profile.php';
include_once ROOT . '/models/Users.php';
include_once ROOT . '/View/AuthregView.php';
include_once ROOT . '/components/Response.php';

class AuthregController
{
    public $model;
    public $view;

    public function actionLogin()
    {
        $this->view = new AuthregView();
        if (!Users::isAlreadyLogin()) {
            $this->view->loginView();
        } else {
            header('Location: profile');
        }
    }
    public function actionLogout()
    {
        $_SESSION = [];
        if ( isset($_COOKIE[session_name()]) ) {
            setcookie(session_name(), '', time()-3600, '/');
            setcookie("hash", '', time()-60*60*24*30, '/');
        }
        session_destroy();
        header('Location: login');
    }
    public function actionRegistration()
    {
        if (!Users::isAlreadyLogin()) {
            AuthregView::registrationView();
        } else {
            header('Location: profile');
        }
    }
}