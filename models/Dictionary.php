<?php

namespace Models;

use Components\DB;

class Dictionary
{

    public static function getDictionaryName($id): string
    {
        $mysqli = DB::connectToDB();
        $result = $mysqli->query("SELECT name FROM dictionaries WHERE dictionaryid = '$id'")->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result[0]['name'];
    }

    public static function createDictionary($wordlistName, $wordlistDiscription, $userid, $isPublic)
    {
        $mysqli = DB::connectToDB();
        $result = mysqli_query($mysqli, "INSERT INTO dictionaries(dictionaryid, name, discription, dictionaryowner, ispublic) VALUES(NULL, '$wordlistName', '$wordlistDiscription', '$userid', '$isPublic')");
        $lastId = $mysqli->insert_id;
        mysqli_query($mysqli, "INSERT INTO users_has_dictionaries(users_userid, dictionaries_dictionaryid) VALUES('$userid', '$lastId')");
        $mysqli->close();
        return $result;
    }

    public static function updateDictionary($dictionaryId, $dictionaryName, $dictionaryDiscription, $isPublic)
    {
        $mysqli = DB::connectToDB();
        return mysqli_query($mysqli, "UPDATE dictionaries SET name = '$dictionaryName', discription = '$dictionaryDiscription', ispublic = '$isPublic' WHERE dictionaryid = '$dictionaryId'");
    }

    public static function removeDictionary(): bool
    {
        $userid = $_SESSION['userid'];
        $dictionaryid = $_SESSION['dictionaryId'];
        if (self::isUserHasADictionary()) {
            $mysqli = DB::connectToDB();
            $query = "DELETE FROM users_has_dictionaries WHERE users_userid = '$userid' AND dictionaries_dictionaryid = '$dictionaryid'";
            $mysqli->query($query);
            return true;
        }
        return false;
    }

    public static function deleteDictionary(): bool
    {
        $dictionaryid = $_SESSION['dictionaryId'];
        if (self::isDictionaryOwner($dictionaryid)) {
            $mysqli = DB::connectToDB();
            $query = "DELETE FROM dictionaries WHERE dictionaryid = '$dictionaryid'";
            $mysqli->query($query);
            return true;
        }
        return false;
    }

    public function getFieldsContent($dictionaryId)
    {
        $mysqli = DB::connectToDB();
        $query = "SELECT * FROM dictionaries WHERE dictionaryid = '$dictionaryId'";
        return $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public static function addDictionaryToUser($dictionaryid, $username)
    {
        $mysqli = DB::connectToDB();
        $userid = Users::getUserId($username);
        $query = "INSERT INTO users_has_dictionaries(users_userid, dictionaries_dictionaryid) VALUES('$userid', '$dictionaryid')";
        return mysqli_query($mysqli, $query);
    }


    public function getUserDictionaries()
    {
        $userid = Users::getUserId($_SESSION['username']);
        $mysqli = DB::connectToDB();
        $result = $mysqli->query("SELECT * FROM dictionaries WHERE ispublic = 1 AND dictionaryid NOT IN
                                (SELECT dictionaries_dictionaryid FROM users_has_dictionaries WHERE users_userid = '$userid')");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else return false;
    }

    public static function isDictionaryNameUsed($dictionaryName): bool
    {
        $mysqli = DB::connectToDB();
        $query = "SELECT name FROM dictionaries WHERE name = '$dictionaryName'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function isDictionaryNameUsedExceptThis($dictionaryName, $id): bool
    {
        $mysqli = DB::connectToDB();
        $query = "SELECT name FROM dictionaries WHERE name = '$dictionaryName' AND dictionaryid != '$id'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function isUserHasADictionary(): bool
    {
        $userid = Users::getUserId($_SESSION['username']);
        $dictionaryid = $_SESSION['dictionaryId'];
        $mysqli = DB::connectToDB();
        $query = "SELECT *
                    FROM users_has_dictionaries
                    WHERE users_userid = '$userid' AND dictionaries_dictionaryid = '$dictionaryid'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function isDictionaryOwner($dictionaryid): bool
    {
        $username = $_SESSION['username'];
        $userid = Users::getUserId($username);
        $mysqli = DB::connectToDB();
        $result = $mysqli->query("SELECT * FROM dictionaries WHERE dictionaryowner = '$userid' AND dictionaryid = '$dictionaryid'")->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function setTitle(): string
    {
        return self::getDictionaryName($_SESSION['dictionaryId']);
    }

}