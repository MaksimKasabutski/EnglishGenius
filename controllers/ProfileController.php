<?php

namespace Controllers;

use Components\DB;
use Core\Controller;
use Models\Profile;

class ProfileController extends Controller
{
    public function actionIndex()
    {
        $this->view->generate('profile.php', 'template.php', Profile::getUsersLists($_SESSION['username']), $_SESSION['username']);
    }


}