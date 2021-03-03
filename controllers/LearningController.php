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
        $this->data = $this->model->getData();
        $this->title = $this->model->getTitle();
        $this->view->generate('learning.php', 'template.php', $this->data, $this->title);
    }
}