<?php

namespace Controllers;

use Core\Controller;
use Models\{Dictionary, Words};

class DictionaryController extends Controller
{

    public function __construct($parameters)
    {
        parent::__construct();
        if(!empty($parameters)) {
            $_SESSION['dictionaryId'] = intval($parameters[0]);
        }
    }

    public function actionData()
    {
        $title = Dictionary::setTitle();
        $data = Words::renderData();
        $this->view->generate('dictionary.php', 'template.php', $data, $title);
    }

    public function actionRemoveDictionary()
    {
        Dictionary::removeDictionary();
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function actionDeleteDictionary()
    {
        Dictionary::deleteDictionary();
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
        $data = $this->model->getUserDictionaries();
        $this->view->generate('dictionaryAdd.php', 'template.php', $data, $title);
    }
}