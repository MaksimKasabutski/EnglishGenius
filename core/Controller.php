<?php
require_once ROOT . '/core/View.php';

class Controller
{
    public $model;
    public $view;

    public function __construct()
    {
        $this->view = new View();
    }

    function actionIndex()
    {

    }
}