<?php
require_once('../Response.php');
require_once('../DictionaryProvider.php');

$request = json_decode(file_get_contents('php://input'), true);


$englishWord = DictionaryProvider::strCleaner(strtolower($request['englishWord']));
$translation = DictionaryProvider::strCleaner(mb_strtolower($request['translation']));
$dictionaryid = $request['dictionaryid'];

if (DictionaryProvider::isStringEnglish($englishWord) or DictionaryProvider::isStringRussian($translation)) {
    $response = new Response('error', 'Wrong word');
    echo json_encode($response);
    return;
}

if (DictionaryProvider::addWordIntoDictionary($englishWord, $translation, $dictionaryid)) {
    $response = new Response('success', 'Word successfully added');
} else {
    $response = new Response('error', 'Something whent wrong');
}

echo json_encode($response);
return;