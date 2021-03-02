<?php
namespace Core;

use Core\View;
use Models\Users;

class Controller
{
    protected $model;
    protected $view;

    public function __construct()
    {
        if(!Users::isAlreadyLogin()) {
            header('Location: login');
        }
        $this->view = new View();
    }
    public function action404() {
        $this->view->generate(NULL, '404.php');
    }
}