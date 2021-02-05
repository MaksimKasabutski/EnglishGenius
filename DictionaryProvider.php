<?php
require_once('UserProvider.php');

class DictionaryProvider
{
    public static function createWordlist($wordlistName, $wordlistDiscription, $userid, $isPublic)
    {
        $mysqli = UserProvider::connectToDB();
        $result = mysqli_query($mysqli, "INSERT INTO dictionaries(dictionaryid, name, discription, wordlistowner, ispublic) VALUES(NULL, '$wordlistName', '$wordlistDiscription', '$userid', '$isPublic')");
        $lastId = $mysqli->insert_id;
        mysqli_query($mysqli, "INSERT INTO users_has_dictionaries(users_userid, dictionaries_dictionaryid) VALUES('$userid', '$lastId')");
        $mysqli->close();
        return $result;
    }

    public static function isWordlistNameUsed($wordlistName): bool
    {
        $mysqli = UserProvider::connectToDB();
        $query = "SELECT name FROM dictionaries WHERE name = '$wordlistName'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function checkWordlistName($wordlistName): bool
    {
        if (preg_match("/[^(\s\w\-)]/u", $wordlistName) == 1 or mb_strlen($wordlistName) < 4 or mb_strlen($wordlistName) > 50) {
            return true;
        } else return false;
    }

    public static function strCleaner($string): string
    {
        return htmlspecialchars(strip_tags(trim($string, " \n\r\t\v\0")));
    }

    public static function getUsersLists($userid): string
    {
        $mysqli = UserProvider::connectToDB();
        $query = "SELECT
                      dictionaries.dictionaryid,
                      dictionaries.name,
                      dictionaries.discription
                    FROM users_has_dictionaries
                      INNER JOIN dictionaries
                        ON users_has_dictionaries.dictionaries_dictionaryid = dictionaries.dictionaryid
                      INNER JOIN users
                        ON users_has_dictionaries.users_userid = users.userid
                        WHERE users.userid = '$userid'
                    ";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        for ($i = 0; $i < count($result); $i++) {
            $link = "http://englishgenius.loc/table.php?id=" . $result[$i]['dictionaryid'];
            $list .= "<a href='" . $link . "'>" . $result[$i]['name'] . "</a><br>";
        }
        return $list;
    }

    public static function isUserHasADictionary($userid, $dictionaryid): bool
    {
        $mysqli = UserProvider::connectToDB();
        $query = "SELECT *
                    FROM users_has_dictionaries
                    WHERE users_userid = '$userid' AND dictionaries_dictionaryid = '$dictionaryid'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function isStringEnglish($string)
    {
        return preg_match("/[^(A-Za-z\')]/u", $string);
    }

    public static function isStringRussian($string)
    {
        return preg_match("/[^(А-Яа-яЁё)]/u", $string);
    }

    public static function addWordIntoDictionary($englishWord, $translation, $dictionaryid)
    {
        $mysqli = UserProvider::connectToDB();
        return mysqli_query($mysqli, "INSERT INTO wordlist(dictionaryid, word, translation) VALUES('$dictionaryid', '$englishWord', '$translation')");
    }
}