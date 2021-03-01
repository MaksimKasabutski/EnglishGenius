<?php
namespace Models;
use Components\{Service, Response};

class Words
{
    public static function addWordIntoDictionary($englishWord, $translation, $dictionaryid, $pos)
    {
        $mysqli = Service::connectToDB();
        return mysqli_query($mysqli, "INSERT INTO wordlist(dictionaryid, word, translation, pos) VALUES('$dictionaryid', '$englishWord', '$translation', '$pos')");
    }

    public static function deleteWord($dictionaryid)
    {
        $mysqli = Service::connectToDB();
        $mysqli->query("DELETE FROM wordlist WHERE wordid='$dictionaryid'");
        $mysqli->close();
    }

    public static function getPos($pos)
    {
        switch ($pos) {
            case 'noun': return 'noun';
            case 'verb': return 'verb';
            case 'adverb': return 'adverb';
            case 'adjective': return 'adjective';
            case 'preposition': return 'preposition';
            default: return NULL;
        }
    }

    public static function wordValidation($engWord, $rusWord)
    {
        if (Service::isEng($engWord)) {
            $response = new Response('error', 'Wrong english word');
            return $response;
        } elseif (Service::isRus($rusWord)) {
            $response = new Response('error', 'Wrong translation');
            return $response;
        } elseif (!Service::checkLength(1, 25, $engWord) or !Service::checkLength(1, 25, $rusWord)) {
            $response = new Response('error', 'The words must be from 1 to 25 symbols.');
            return $response;
        }
        return NULL;
    }

    public static function updateWord($engWord, $rusWord, $wordid, $pos): bool
    {
        $mysqli = Service::connectToDB();
        $query = "UPDATE wordlist SET word = '$engWord', translation = '$rusWord', pos = '$pos' WHERE wordid = '$wordid'";
        return mysqli_query($mysqli, $query);
    }

    public static function getWordContent($wordid)
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT wordid, word, translation, pos FROM wordlist WHERE wordid = '$wordid'";
        return $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public static function getDictionaryName($wordid): string
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT name FROM dictionaries WHERE dictionaryid = (SELECT dictionaryid FROM wordlist WHERE wordid = '$wordid')";
        $result =  $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        return $result[0]['name'];
    }
}