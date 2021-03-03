<?php

namespace Models;

use Components\DB;
use Components\Pagination;

class Words
{
    public static function renderData(): string
    {
        $dictionaryId = $_SESSION['dictionaryId'];
        $pagi = new Pagination(isset($_SESSION['rowsnumber']) ? $_SESSION['rowsnumber'] : 5);
        $pagi->createPagination();
        $html = $pagi->createPagination();
        $html .= self::renderRowsSelector();
        $html .= "<table class='table table-inverse'><tr>
            <th class='col-5'>English word</th>
            <th class='col-5'>Translation</th>";
        if (Dictionary::isDictionaryOwner($dictionaryId)) {
            $html .= '<th class="col-2">Actions</th>';
        }
        $html .= '</tr>';
        $firstWord = $pagi->getFirstWord();
        $data = self::getPartsOfWords($firstWord, $pagi->wordsPerPage);
        if (empty($data)) {
            $html .= "<tr id='warning'><td> There is nothing here yet.</td></tr>";
            return $html;
        }
        foreach ($data as $wordpare) {
            $html .= "<tr id='" . $wordpare['wordid'] . "'><td>" . $wordpare['word'] . " <div class='pos'>" . $wordpare['pos'] . "</div></td><td>" . $wordpare['translation'] . "</td>";
            if (Dictionary::isDictionaryOwner($dictionaryId)) {
                $updateLink = URL . 'word/update/' . $wordpare['wordid'];
                $html .= "<td>\n<button class='btn btn-outline-primary btn-sm' onclick='deleteWord(" . $dictionaryId . ", " . $wordpare['wordid'] . ")'>Del</button>\n";
                $html .= '<a class="btn btn-outline-primary btn-sm ml5" href="' . $updateLink . '">
                              Edit
                          </a></td>';
            }
            $html .= "</tr>";
        }
        $html .= '</table>';
        return $html;
    }

    public static function renderRowsSelector()
    {
        $values = array(5, 10, 20, 50);
        $selectedValue = self::getRowsNumber();
        $html = '<div class="rows">
                <form id="rows">
                    <label for="session-max-rows">Count of rows:</label>
                    <select id="session-max-rows" class="form-select form-select-sm" onchange="setSessionMaxRows()">';
        foreach ($values as $value) {
            if ($value == $selectedValue) {
                $html .= "<option selected value='$value'>$value</option>";
            } else {
                $html .= "<option value='$value'>$value</option>";
            }
        }
        $html .= '</select></form></div>';
        return $html;
    }

    public static function addWordIntoDictionary($englishWord, $translation, $dictionaryid, $pos)
    {
        $mysqli = DB::connectToDB();
        return mysqli_query($mysqli, "INSERT INTO wordlist(dictionaryid, word, translation, pos) VALUES('$dictionaryid', '$englishWord', '$translation', '$pos')");
    }

    public static function getPos($pos)
    {
        switch ($pos) {
            case 'noun':
                return 'noun';
            case 'verb':
                return 'verb';
            case 'adverb':
                return 'adverb';
            case 'adjective':
                return 'adjective';
            case 'preposition':
                return 'preposition';
            default:
                return NULL;
        }
    }

    public static function updateWord($engWord, $rusWord, $wordid, $pos): bool
    {
        $mysqli = DB::connectToDB();
        $query = "UPDATE wordlist SET word = '$engWord', translation = '$rusWord', pos = '$pos' WHERE wordid = '$wordid'";
        return mysqli_query($mysqli, $query);
    }

    private static function getWords($query)
    {
        if (Dictionary::isUserHasADictionary()) {
            $mysqli = DB::connectToDB();
            $data = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
            $mysqli->close();
            return $data;
        } else return 'Access denied.';
    }

    public static function getPartsOfWords($firstWord, $wordsPerPage)
    {
        $dictionaryId = $_SESSION['dictionaryId'];
        $query = "SELECT wordid, word, translation, pos FROM wordlist WHERE dictionaryid = '$dictionaryId' ORDER BY word LIMIT $firstWord, $wordsPerPage";
        return self::getWords($query);
    }

    public static function getAllWords()
    {
        $dictionaryId = $_SESSION['dictionaryId'];
        $query = "SELECT word, translation, pos FROM wordlist WHERE dictionaryid = '$dictionaryId'";
        return self::getWords($query);
    }

    public static function getWordContent($wordid)
    {
        $mysqli = DB::connectToDB();
        $query = "SELECT wordid, word, translation, pos FROM wordlist WHERE wordid = '$wordid'";
        return $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public static function getDictionaryName($wordid): string
    {
        $mysqli = DB::connectToDB();
        $query = "SELECT name FROM dictionaries WHERE dictionaryid = (SELECT dictionaryid FROM wordlist WHERE wordid = '$wordid')";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        return $result[0]['name'];
    }

    public static function getRowsNumber()
    {
        $mysqli = DB::connectToDB();
        $userid = $_SESSION['userid'];
        $query = "SELECT rowsnumber FROM users WHERE userid = '$userid'";
        return $mysqli->query($query)->fetch_all(MYSQLI_ASSOC)[0]['rowsnumber'];
    }

}