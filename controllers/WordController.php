<?php
require_once ROOT . '/models/Users.php';
require_once ROOT . '/models/Words.php';
require_once ROOT . '/models/Dictionary.php';

class WordController extends Controller
{

    public function actionUpdate($parameters)
    {
        if (Users::isAlreadyLogin()) {
            $this->model = new Words();
            $title = 'Update word - EnglishGenius';
            $wordid = $parameters[0];
            $data = $this->model->getWordContent($wordid);
            $data['dictionaryname'] = $this->model->getDictionaryName($wordid);
            $data['dictionaryid'] = Dictionary::getDictionaryId($data['dictionaryname']);
            $this->view->generate('wordUpdate.php', 'template.php', $data, $title);
        } else {
            header('Location: login');
        }
    }
}