<?php
require_once('../Response.php');
require_once('../WordProvider.php');


$request = json_decode(file_get_contents('php://input'), true);
$dictionaryid = $request['dictionaryid'];

WordProvider::deleteWord($dictionaryid);
$response = new Response('success', 'Successfully deleted');
echo json_encode($response);
return;
