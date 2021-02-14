<?php
require_once('../Response.php');
require_once('../Words.php');

$request = json_decode(file_get_contents('php://input'), true);


$englishWord = Service::strCleaner(mb_strtolower($request['englishWord']));
$translation = Service::strCleaner(mb_strtolower($request['translation']));
$dictionaryid = $request['dictionaryid'];

if (Service::isEng($englishWord) or Service::isRus($translation)) {
    $response = new Response('error', 'Wrong word');
    echo json_encode($response);
    return;
} elseif(!Service::checkLength(1, 25, $englishWord) or !Service::checkLength(1, 25, $translation)) {
    $response = new Response('error', 'The words must be from 1 to 25 symbols.');
    echo json_encode($response);
    return;
}

if (Words::addWordIntoDictionary($englishWord, $translation, $dictionaryid)) {
    $response = new Response('success', 'Word successfully added');
} else {
    $response = new Response('error', 'Something whent wrong');
}

echo json_encode($response);
return;