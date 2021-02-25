<?php
require_once(ROOT . '/components/Service.php');

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
            default: return NULL;
        }
    }
}