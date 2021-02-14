<?php
require_once(ROOT . '/components/Service.php');
require_once(ROOT . '/models/Users.php');

class Dictionary
{

    public static function getWordlistName($id)
    {
        $mysqli = Service::connectToDB();
        $result = $mysqli->query("SELECT name FROM dictionaries WHERE dictionaryid = '$id'")->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result[0]['name'];
    }

    public static function createWordlist($wordlistName, $wordlistDiscription, $userid, $isPublic)
    {
        $mysqli = Service::connectToDB();
        $result = mysqli_query($mysqli, "INSERT INTO dictionaries(dictionaryid, name, discription, wordlistowner, ispublic) VALUES(NULL, '$wordlistName', '$wordlistDiscription', '$userid', '$isPublic')");
        $lastId = $mysqli->insert_id;
        mysqli_query($mysqli, "INSERT INTO users_has_dictionaries(users_userid, dictionaries_dictionaryid) VALUES('$userid', '$lastId')");
        $mysqli->close();
        return $result;
    }

    public static function isWordlistNameUsed($wordlistName): bool
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT name FROM dictionaries WHERE name = '$wordlistName'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function checkWordlistName($wordlistName): bool
    {
        if (preg_match("/[^(\s\w\-)]/u", $wordlistName) != 1 and Service::checkLength(4, 50, $wordlistName)) {
            return true;
        } else return false;
    }

    public static function isUserHasADictionary($userid, $dictionaryid): bool
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT *
                    FROM users_has_dictionaries
                    WHERE users_userid = '$userid' AND dictionaries_dictionaryid = '$dictionaryid'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public function setTitle($id)
    {
        return self::getWordlistName($id);
    }

}