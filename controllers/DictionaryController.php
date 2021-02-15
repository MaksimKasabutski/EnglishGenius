<?php
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/models/Users.php';
require_once ROOT . '/models/Dictionary.php';

class DictionaryController extends Controller
{

    public function actionData($parameters)
    {
        if (Users::isAlreadyLogin()) {
            $dictionaryid = $parameters[0];
            $this->model = new Dictionary();
            $title = $this->model->setTitle($dictionaryid);
            $data = $this->model->getWords($dictionaryid);
            $this->view->generate('dictionaryView.php', 'templateView.php', $data, $title);
        } else {
            header('Location: login');
        }
    }

    public function actionDeleteWord($parameters)
    {
        print_r($parameters);
        $this->model = new Dictionary();
        if($this->model->deleteWord($parameters)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else echo 'error';
    }
}