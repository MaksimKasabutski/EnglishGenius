<?php
require_once(ROOT . '/components/Service.php');

class Words
{
    public static function addWordIntoDictionary($englishWord, $translation, $dictionaryid)
    {
        $mysqli = Service::connectToDB();
        return mysqli_query($mysqli, "INSERT INTO wordlist(dictionaryid, word, translation) VALUES('$dictionaryid', '$englishWord', '$translation')");
    }

    public static function getDictionaryWords($wordlistId): array
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT wordid, word, translation FROM wordlist WHERE dictionaryid = '$wordlistId'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result;
    }

    public static function deleteWord($dictionaryid)
    {
        $mysqli = Service::connectToDB();
        $mysqli->query("DELETE FROM wordlist WHERE wordid='$dictionaryid'");
        $mysqli->close();
    }
}