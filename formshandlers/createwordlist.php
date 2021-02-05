<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once('../Response.php');
require_once('../DictionaryProvider.php');

$request = json_decode(file_get_contents('php://input'), true);


$wordlistName = DictionaryProvider::strCleaner($request['wordlistName']);
$wordlistDiscription = DictionaryProvider::strCleaner($request['wordlistDiscription']);
if(!$request['isPublic']) {
    $isPublic = 0;
} else $isPublic = 1;
$userid = $_SESSION['userid'];

if(DictionaryProvider::isWordlistNameUsed($wordlistName)) {
    $response = new Response('error', 'This name is already taken.');
    echo json_encode($response);
    return;
} elseif(DictionaryProvider::checkWordlistName($wordlistName)) {
    $response = new Response('error', 'Wrong name.');
    echo json_encode($response);
    return;
}
if(DictionaryProvider::createWordlist($wordlistName, $wordlistDiscription, $userid, $isPublic)) {
        $response = new Response('success', 'Wordlist created successfully');
    } else {
        $response = new Response('error', 'Something whent wrong');
    }

echo json_encode($response);
return;