<?php

namespace Controllers;

use Core\Controller;
use Models\{Users, Dictionary};

class DictionaryController extends Controller
{

    public function actionData($parameters)
    {
        $dictionaryid = $parameters[0];
        $this->model = new Dictionary();
        $title = $this->model->setTitle($dictionaryid);
        $data = $this->model->getWords($dictionaryid);
        $this->view->generate('dictionary.php', 'template.php', $data, $title);
    }

    public function actionRemoveDictionary($parameters)
    {
        Dictionary::removeDictionary($parameters);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function actionDeleteDictionary($parameters)
    {
        Dictionary::deleteDictionary($parameters);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function actionCreate()
    {
        $title = 'Create dictionary - EnglishGenius';
        $this->view->generate('dictionaryCreateUpdate.php', 'template.php', NULL, $title);
    }

    public function actionUpdate($parameters)
    {
        $this->model = new Dictionary();
        $title = 'Update dictionary - EnglishGenius';
        $dictionaryid = $parameters[0];
        $data = $this->model->getFieldsContent($dictionaryid);
        $this->view->generate('dictionaryCreateUpdate.php', 'template.php', $data, $title);
    }

    public function actionAdd()
    {
        $this->model = new Dictionary();
        $title = 'Add dictionary - EnglishGenius';
        $data = $this->model->getAllDictionaries();
        $this->view->generate('dictionaryAdd.php', 'template.php', $data, $title);
    }
}