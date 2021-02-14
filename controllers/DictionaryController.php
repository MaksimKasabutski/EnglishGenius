<?php
include_once ROOT . '/models/Users.php';
include_once ROOT . '/models/Dictionary.php';
include_once ROOT . '/view/DictionaryView.php';

class DictionaryController
{
    public $model;
    public $view;

    public function actionView($parameters)
    {
        $dictionaryid = $parameters[0];
        if (Users::isAlreadyLogin()) {
            $this->model = new Dictionary();
            $title = $this->model->setTitle($dictionaryid);
            $this->view = new DictionaryView();
            $this->view->view('main_view.php', 'template_view.php', $title);
        } else {
            header('Location: login');
        }
    }


}