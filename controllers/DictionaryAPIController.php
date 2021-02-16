<?php
require_once ROOT . '/models/Users.php';
require_once ROOT . '/models/Dictionary.php';
require_once ROOT . '/components/Security.php';
require_once ROOT . '/components/Response.php';

class DictionaryAPIController
{
    public function actionCreate()
    {
        if (Users::isAlreadyLogin()) {
            $request = json_decode(file_get_contents('php://input'), true);


            $wordlistName = Service::strCleaner($request['wordlistName']);
            $wordlistDiscription = Service::strCleaner($request['wordlistDiscription']);
            if (!$request['isPublic']) {
                $isPublic = 0;
            } else $isPublic = 1;
            $userid = $_SESSION['userid'];

            if (Dictionary::isWordlistNameUsed($wordlistName)) {
                $response = new Response('error', 'This name is already taken.');
                echo json_encode($response);
                return;
            } elseif (!Dictionary::checkWordlistName($wordlistName)) {
                $response = new Response('error', 'Wrong name.');
                echo json_encode($response);
                return;
            }
            if (Dictionary::createWordlist($wordlistName, $wordlistDiscription, $userid, $isPublic)) {
                $response = new Response('success', 'Wordlist created successfully');
            } else {
                $response = new Response('error', 'Something whent wrong');
            }
        } else {
            $response = new Response('error', 'Something whent wrong');
        }
        echo json_encode($response);
    }
}