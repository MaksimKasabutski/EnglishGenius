<?php
require_once ROOT . '/controllers/DictionaryAPIController.php';

class WordAPIController extends DictionaryAPIController
{
    private $pos;
    private $engWord;
    private $rusWord;
    private $wordid;

    public function __construct()
    {
        parent::__construct();
        $this->pos = isset($this->request['pos']) ? Words::getPos($this->request['pos']) : NULL;
        $this->engWord = Service::strCleaner(mb_strtolower(isset($this->request['englishWord']) ? $this->request['englishWord'] : NULL));
        $this->rusWord = Service::strCleaner(mb_strtolower(isset($this->request['translation']) ? $this->request['translation'] : NULL));
        $this->wordid = isset($this->request['wordid']) ? $this->request['wordid'] : NULL;
    }

    public function actionDeleteWord($parameters)
    {
        if (Dictionary::isDictionaryOwner($this->dictionaryId) and $this->wordid) {
            if (mysqli_query(Service::connectToDB(), "DELETE FROM wordlist WHERE wordid = '$this->wordid'")) {
                $response = new Response('success', '');
                echo json_encode($response);
                return;
            }
        } else echo json_encode(new Response('error', ''));
    }

    public function actionAddWord()
    {
        if (Service::isEng($this->engWord)) {
            $response = new Response('error', 'Wrong english word');
            echo json_encode($response);
            return;
        } elseif (Service::isRus($this->rusWord)) {
            $response = new Response('error', 'Wrong translation');
            echo json_encode($response);
            return;
        } elseif (!Service::checkLength(1, 25, $this->engWord) or !Service::checkLength(1, 25, $this->rusWord)) {
            $response = new Response('error', 'The words must be from 1 to 25 symbols.');
            echo json_encode($response);
            return;
        }
        if (Words::addWordIntoDictionary($this->engWord, $this->rusWord, $this->dictionaryId, $this->pos)) {
            $response = new Response('success', 'Word successfully added');
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }
}