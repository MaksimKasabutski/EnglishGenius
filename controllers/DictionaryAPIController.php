<?php
namespace Controllers;
use Core\APIController;
use Components\{DB, Response, Validation};
use Models\Dictionary;

class DictionaryAPIController extends APIController
{
    protected $dictionaryId;
    protected $dictionaryName;
    protected $dictionaryDiscription;
    protected $username;
    protected $isPublic;
    protected $userid;

    public function __construct()
    {
        parent::__construct();
        $this->dictionaryId = isset($this->request['dictionaryId']) ? $this->request['dictionaryId'] : NULL;
        $this->dictionaryName = Validation::strCleaner(isset($this->request['dictionaryName']) ? $this->request['dictionaryName'] : NULL);
        $this->dictionaryDiscription = Validation::strCleaner(isset($this->request['dictionaryDiscription']) ? $this->request['dictionaryDiscription'] : NULL);
        $this->isPublic = isset($this->request['isPublic']) ? ($this->request['isPublic'] ? 1 : 0) : NULL;
        $this->username = $_SESSION['username'];
        $this->userid = $_SESSION['userid'];
    }

    public function actionCreate()
    {
        if (Dictionary::isDictionaryNameUsed($this->dictionaryName)) {
            $response = new Response('error', 'This name is already taken.');
            echo json_encode($response);
            return;
        } elseif (!Validation::checkDictionaryName($this->dictionaryName)) {
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
        if (Dictionary::isDictionaryNameUsedExceptThis($this->dictionaryName, $this->dictionaryId)) {
            $response = new Response('error', 'This name is already taken.');
            echo json_encode($response);
            return;
        } elseif (!Validation::checkDictionaryName($this->dictionaryName)) {
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

    public function actionSetRowsNumber()
    {
        $rowsNumber = $this->request['rowsnumber'];
        $mysqli = DB::connectToDB();
        $_SESSION['rowsnumber'] = $rowsNumber;
        $userid = $_SESSION['userid'];
        $query = "UPDATE users SET rowsnumber = '$rowsNumber' WHERE userid = '$userid'";
        if(mysqli_query($mysqli, $query)) {
            $response = new Response('success', NULL);
        } else {
            $response = new Response('error', 'Update failed');
        }
        echo json_encode($response);
    }
}