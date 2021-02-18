<?php
require_once ROOT . '/models/Profile.php';
require_once ROOT . '/models/Dictionary.php';
require_once ROOT . '/models/Users.php';

class ProfileController extends Controller
{
    public function actionIndex()
    {
        if (Users::isAlreadyLogin()) {
            $title = $_SESSION['username'];
            $this->view->generate('profile.php', 'template.php', Profile::getUsersLists($_SESSION['username']), $title);
        } else {
            header('Location: login');
        }
    }
}