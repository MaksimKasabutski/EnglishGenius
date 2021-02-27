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
            $this->view->generate('dictionary.php', 'template.php', $data, $title);
        } else {
            header('Location: login');
        }
    }

    public function actionDeleteWord($parameters) /*ДОДЕЛАТЬ*/
    {
        if (Users::isAlreadyLogin()) {
            $this->model = new Dictionary();
            if (WordAPIController::deleteWord($parameters)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else echo 'error';
        } else {
            header('Location: login');
        }
    }

    public function actionRemoveDictionary($parameters): bool
    {
        if (Users::isAlreadyLogin()) {
            $this->model = new Dictionary();
            if ($this->model->removeDictionary($parameters)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            header('Location: login');
        }
    }

    public function actionDeleteDictionary($parameters)
    {
        if (Users::isAlreadyLogin()) {
            $this->model = new Dictionary();
            if ($this->model->deleteDictionary($parameters)) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        } else {
            header('Location: login');
        }
    }

    public function actionCreate()
    {
        if (Users::isAlreadyLogin()) {
            $title = 'Create dictionary - EnglishGenius';
            $this->view->generate('dictionaryCreateUpdate.php', 'template.php', NULL, $title);
        } else {
            header('Location: login');
        }
    }

    public function actionUpdate($parameters)
    {
        if (Users::isAlreadyLogin()) {
            $this->model = new Dictionary();
            $title = 'Update dictionary - EnglishGenius';
            $dictionaryid = $parameters[0];
            $data = $this->model->getFieldsContent($dictionaryid);
            $this->view->generate('dictionaryCreateUpdate.php', 'template.php', $data, $title);
        } else {
            header('Location: login');
        }
    }

    public function actionAdd()
    {
        if (Users::isAlreadyLogin()) {
            $this->model = new Dictionary();
            $title = 'Add dictionary - EnglishGenius';
            $data = $this->model->getAllDictionaries();
            $this->view->generate('dictionaryAdd.php', 'template.php', $data, $title);
        } else {
            header('Location: login');
        }
    }
}