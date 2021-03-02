<?php
namespace Controllers;
use Models\{Words, Dictionary};
use Components\{DB, Response, Validation};

class WordAPIController extends DictionaryAPIController
{
    protected $pos;
    protected $engWord;
    protected $rusWord;
    protected $wordid;

    public function __construct()
    {
        parent::__construct();
        $this->pos = isset($this->request['pos']) ? Words::getPos($this->request['pos']) : NULL;
        $this->engWord = Validation::strCleaner(mb_strtolower(isset($this->request['englishWord']) ? $this->request['englishWord'] : NULL));
        $this->rusWord = Validation::strCleaner(mb_strtolower(isset($this->request['translation']) ? $this->request['translation'] : NULL));
        $this->wordid = isset($this->request['wordid']) ? $this->request['wordid'] : NULL;
    }

    public function actionDelete($parameters)
    {
        if (Dictionary::isDictionaryOwner($this->dictionaryId) and $this->wordid) {
            if (mysqli_query(DB::connectToDB(), "DELETE FROM wordlist WHERE wordid = '$this->wordid'")) {
                $response = new Response('success', '');
                echo json_encode($response);
                return;
            }
        } else echo json_encode(new Response('error', ''));
    }

    public function actionAdd()
    {
        $response = Validation::wordValidation($this->engWord, $this->rusWord);
        if ($response) {
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

    public function actionUpdate()
    {
        $response = Validation::wordValidation($this->engWord, $this->rusWord);
        if ($response) {
            echo json_encode($response);
            return;
        }
        if (Words::updateWord($this->engWord, $this->rusWord, $this->wordid, $this->pos)) {
            $response = new Response('success', 'Word successfully updated');
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }
}