<?php


namespace Controllers;

use Core\Controller;
use Models\Learning;

class LearningController extends Controller
{
    private $data;
    private $title;

    public function actionIndex($parameters)
    {
        $this->model = new Learning($parameters);
        $this->model->createFile();
        $this->data = $this->model->getArray(0);
        $this->title = $this->model->getTitle();
        $this->view->generate('learning.php', 'template.php', $this->data, $this->title);
    }
}