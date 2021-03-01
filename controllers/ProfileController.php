<?php

namespace Controllers;

use Core\Controller;
use Models\{Users, Profile};

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $this->view->generate('profile.php', 'template.php', Profile::getUsersLists($_SESSION['username']), $_SESSION['username']);
    }
}