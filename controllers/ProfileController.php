<?php
include_once ROOT . '/models/Profile.php';
include_once ROOT . '/models/Dictionary.php';
include_once ROOT . '/models/Users.php';
include_once ROOT . '/View/ProfileView.php';


class ProfileController
{
    public function actionData()
    {
        if (Users::isAlreadyLogin()) {
            $title = $_SESSION['username'];
            $data = Profile::getUsersLists($_SESSION['username']);
            ProfileView::view($data, $title);
        } else {
            header('Location: login');
        }
    }
}