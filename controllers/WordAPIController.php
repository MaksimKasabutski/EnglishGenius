<?php
require_once ROOT . '/controllers/DictionaryAPIController.php';

class WordAPIController extends DictionaryAPIController
{
    public function actionAddWordIntoDictionary()
    {
        if (Service::isEng($this->engWord) or Service::isRus($this->rusWord)) {
            $response = new Response('error', 'Wrong word');
            echo json_encode($response);
            return;
        } elseif (!Service::checkLength(1, 25, $this->engWord) or !Service::checkLength(1, 25, $this->rusWord)) {
            $response = new Response('error', 'The words must be from 1 to 25 symbols.');
            echo json_encode($response);
            return;
        }
        if (Words::addWordIntoDictionary($this->engWord, $this->rusWord, $this->dictionaryId)) {
            $response = new Response('success', 'Word successfully added');
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }
}