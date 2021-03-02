<?php

namespace Models;

use Components\DB;
use Components\Pagination;

class Words
{
    public static function renderData(): string
    {
        $dictionaryId = $_SESSION['dictionaryId'];
        $pagi = new Pagination(5);
        $pagi->createPagination();
        $html = $pagi->createPagination();
        $html .= "<table class='table table-inverse'><tr>
            <th class='col-5'>English word</th>
            <th class='col-5'>Translation</th>";
        if (Dictionary::isDictionaryOwner($dictionaryId)) {
            $html .= '<th class="col-2">Actions</th>';
        }
        $html .= '</tr>';
        $firstWord = $pagi->getFirstWord();
        $data = self::getWords($firstWord, $pagi->wordsPerPage);
        if (empty($data)) {
            $html .= "<tr id='warning'><td> There is nothing here yet.</td></tr>";
            return $html;
        }
        foreach ($data as $wordpare) {
            $html .= "<tr id='" . $wordpare['wordid'] . "'><td>" . $wordpare['word'] . " <div class='pos'>" . $wordpare['pos'] . "</div></td><td>" . $wordpare['translation'] . "</td>";
            if (Dictionary::isDictionaryOwner($dictionaryId)) {
                $updateLink = URL . 'word/update/' . $wordpare['wordid'];
                $html .= "<td>\n<button class='btn btn-primary btn-sm' onclick='deleteWord(" . $dictionaryId . ", " . $wordpare['wordid'] . ")'>Del</button>\n";
                $html .= '<a class="btn btn-primary btn-sm ml5" href="' . $updateLink . '">
                              Edit
                          </a></td>';
            }
            $html .= "</tr>";
        }
        $html .= '</table>';
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

    public static function getWords($firstWord, $wordsPerPage)
    {
        $dictionaryId = $_SESSION['dictionaryId'];
        if (Dictionary::isUserHasADictionary()) {
            $mysqli = DB::connectToDB();
            $query = "SELECT wordid, word, translation, pos FROM wordlist WHERE dictionaryid = '$dictionaryId' ORDER BY word LIMIT $firstWord, $wordsPerPage";
            $data = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
            $mysqli->close();
            return $data;
        } else return 'Access denied.';
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


}