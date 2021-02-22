<?php
require_once ROOT . '/models/Users.php';
require_once ROOT . '/models/Words.php';
require_once ROOT . '/models/Dictionary.php';
require_once ROOT . '/components/Security.php';
require_once ROOT . '/components/Response.php';

class DictionaryAPIController
{
    protected $request;
    protected $dictionaryId;
    protected $dictionaryName;
    protected $dictionaryDiscription;
    protected $username;
    protected $isPublic;
    protected $userid;
    protected $engWord;
    protected $rusWord;

    public function __construct()
    {
        $this->request = json_decode(file_get_contents('php://input'), true);
        $this->dictionaryId = isset($this->request['dictionaryId']) ? $this->request['dictionaryId'] : NULL;
        $this->dictionaryName = Service::strCleaner(isset($this->request['dictionaryName']) ? $this->request['dictionaryName'] : NULL);
        $this->dictionaryDiscription = Service::strCleaner(isset($this->request['dictionaryDiscription']) ? $this->request['dictionaryDiscription'] : NULL);
        $this->isPublic = isset($this->request['isPublic']) ? ($this->request['isPublic'] ? 1 : 0 ) : NULL;
        $this->username = $_SESSION['username'];
        $this->userid = $_SESSION['userid'];
        $this->engWord = Service::strCleaner(mb_strtolower(isset($this->request['englishWord']) ? $this->request['englishWord'] : NULL ));
        $this->rusWord = Service::strCleaner(mb_strtolower(isset($this->request['translation']) ? $this->request['translation'] : NULL));
    }

    public function actionCreate()
    {
        if (Dictionary::isWordlistNameUsed($this->dictionaryName)) {
            $response = new Response('error', 'This name is already taken.');
            echo json_encode($response);
            return;
        } elseif (!Dictionary::checkWordlistName($this->dictionaryName)) {
            $response = new Response('error', 'Wrong name.');
            echo json_encode($response);
            return;
        }
        if (Dictionary::createDictionary($this->dictionaryName, $this->dictionaryDiscription, $this->userid, $this->isPublic)) {
            $response = new Response('success', 'Wordlist created successfully');
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }

    public function actionUpdate()
    {
        if (Dictionary::isWordlistNameUsedExceptThis($this->dictionaryName, $this->dictionaryId)) {
            $response = new Response('error', 'This name is already taken.');
            echo json_encode($response);
            return;
        } elseif (!Dictionary::checkWordlistName($this->dictionaryName)) {
            $response = new Response('error', 'Wrong name.');
            echo json_encode($response);
            return;
        }
        if (Dictionary::updateDictionary($this->dictionaryId, $this->dictionaryName, $this->dictionaryDiscription, $this->isPublic)) {
            $response = new Response('success', 'Dictionary updated successfully');
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }

    public function actionAddDictionaryToUser()
    {
        if (Dictionary::addDictionaryToUser($this->dictionaryId, $this->username)) {
            $response = new Response('success', '');
        } else {
            $response = new Response('error', '');
        }
        echo json_encode($response);
    }
}