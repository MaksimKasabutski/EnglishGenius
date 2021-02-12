<?php
require_once('../Response.php');
require_once('../Words.php');


$request = json_decode(file_get_contents('php://input'), true);
$dictionaryid = $request['dictionaryid'];

Words::deleteWord($dictionaryid);
$response = new Response('success', 'Successfully deleted');
echo json_encode($response);
return;
