<?php

namespace Controllers;

use Core\Controller;
use Models\{Words, Dictionary};


class WordController extends Controller
{

    public function actionUpdate($parameters)
    {
        $this->model = new Words();
        $title = 'Update word - EnglishGenius';
        $wordid = $parameters[0];
        $data = $this->model->getWordContent($wordid);
        $data['dictionaryname'] = $this->model->getDictionaryName($wordid);
        $this->view->generate('wordUpdate.php', 'template.php', $data, $title);
    }
}