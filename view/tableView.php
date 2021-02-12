<?php
include_once('../Words.php');

function renderWords()
{
    $dictionaryId = $_GET['id'];
    $words = Words::getDictionaryWords($dictionaryId);
    $result = "<div class='col-sm-4'><table class='table table-inverse'><tr><th>English word</th><th>Translation</th></tr>";
    foreach ($words as $wordpare) {
        $wordId = $wordpare['wordid'];
        $result .= "<tr><td>" . $wordpare['word'] . "</td><td>" . $wordpare['translation'] . "</td><td><a href='#' onclick='DeleteWord($wordId)'>DEL</a></td></tr>";
    }
    $result .= "</table></div>";
    echo $result;
}