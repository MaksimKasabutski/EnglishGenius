<?php
include_once('Service.php');
include_once('UserProvider.php');

class DictionaryProvider
{
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

    public static function getUsersLists($userid): string
    {
        $mysqli = Service::connectToDB();
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

}