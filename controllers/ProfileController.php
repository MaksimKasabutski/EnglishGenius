<?php
include_once ROOT . '/models/Profile.php';
include_once ROOT . '/models/Dictionaries.php';
include_once ROOT . '/models/Users.php';
include_once ROOT . '/View/ProfileView.php';


class ProfileController
{
    public function actionData()
    {
        if (Users::isAlreadyLogin()) {
            self::setTitle();
            $data = Profile::getUsersLists($_SESSION['username']);
            ProfileView::view($data);
        } else {
            header('Location: login');
        }
    }

    private function setTitle()
    {
        $_SESSION['title'] = $_SESSION['username'];
    }

}