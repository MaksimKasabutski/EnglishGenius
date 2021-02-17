<?php
require_once ROOT . '/models/Users.php';
require_once ROOT . '/models/Dictionary.php';
require_once ROOT . '/components/Security.php';
require_once ROOT . '/components/Response.php';

class DictionaryAPIController
{
    public function actionCreate()
    {
        $request = json_decode(file_get_contents('php://input'), true);

        $dictionaryName = Service::strCleaner($request['dictionaryName']);
        $dictionaryDiscription = Service::strCleaner($request['dictionaryDiscription']);
        if (!$request['isPublic']) {
            $isPublic = 0;
        } else $isPublic = 1;
        $userid = $_SESSION['userid'];

        if (Dictionary::isWordlistNameUsed($dictionaryName)) {
            $response = new Response('error', 'This name is already taken.');
            echo json_encode($response);
            return;
        } elseif (!Dictionary::checkWordlistName($dictionaryName)) {
            $response = new Response('error', 'Wrong name.');
            echo json_encode($response);
            return;
        }
        if (Dictionary::createDictionary($dictionaryName, $dictionaryDiscription, $userid, $isPublic)) {
            $response = new Response('success', 'Wordlist created successfully');
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }

    public function actionUpdate($parameters)
    {
        $request = json_decode(file_get_contents('php://input'), true);

        $dictionaryId = Service::strCleaner($request['dictionaryId']);
        $dictionaryName = Service::strCleaner($request['dictionaryName']);
        $dictionaryDiscription = Service::strCleaner($request['dictionaryDiscription']);
        if (!$request['isPublic']) {
            $isPublic = 0;
        } else $isPublic = 1;


        if (Dictionary::isWordlistNameUsedExceptId($dictionaryName, $dictionaryId)) {
            $response = new Response('error', 'This name is already taken.');
            echo json_encode($response);
            return;
        } elseif (!Dictionary::checkWordlistName($dictionaryName)) {
            $response = new Response('error', 'Wrong name.');
            echo json_encode($response);
            return;
        }
        if (Dictionary::updateDictionary($dictionaryId, $dictionaryName, $dictionaryDiscription, $isPublic)) {
            $response = new Response('success', 'Dictionary updated successfully');
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }
}