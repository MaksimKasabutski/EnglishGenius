<?php
require_once ROOT . '/components/Service.php';
require_once ROOT . '/models/Users.php';
require_once ROOT . '/models/Words.php';

class Dictionary
{

    public static function getDictionaryName($id)
    {
        $mysqli = Service::connectToDB();
        $result = $mysqli->query("SELECT name FROM dictionaries WHERE dictionaryid = '$id'")->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result[0]['name'];
    }

    public static function getDictionaryId($name)
    {
        $mysqli = Service::connectToDB();
        $result = $mysqli->query("SELECT dictionaryid FROM dictionaries WHERE name = '$name'")->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result[0]['dictionaryid'];
    }

    public static function createDictionary($wordlistName, $wordlistDiscription, $userid, $isPublic)
    {
        $mysqli = Service::connectToDB();
        $result = mysqli_query($mysqli, "INSERT INTO dictionaries(dictionaryid, name, discription, dictionaryowner, ispublic) VALUES(NULL, '$wordlistName', '$wordlistDiscription', '$userid', '$isPublic')");
        $lastId = $mysqli->insert_id;
        mysqli_query($mysqli, "INSERT INTO users_has_dictionaries(users_userid, dictionaries_dictionaryid) VALUES('$userid', '$lastId')");
        $mysqli->close();
        return $result;
    }

    public static function updateDictionary($dictionaryId, $dictionaryName, $dictionaryDiscription, $isPublic)
    {
        $mysqli = Service::connectToDB();
        return mysqli_query($mysqli, "UPDATE dictionaries SET name = '$dictionaryName', discription = '$dictionaryDiscription', ispublic = '$isPublic' WHERE dictionaryid = '$dictionaryId'");
    }

    public static function addDictionaryToUser($dictionaryid, $username)
    {
        $mysqli = Service::connectToDB();
        $userid = Users::getUserId($username);
        $query = "INSERT INTO users_has_dictionaries(users_userid, dictionaries_dictionaryid) VALUES('$userid', '$dictionaryid')";
        return mysqli_query($mysqli, $query);
    }

    public function removeDictionary($parameters): bool
    {
        $userid = Users::getUserId($_SESSION['username']);
        $dictionaryid = $parameters[0];
        if (self::isUserHasADictionary($userid, $dictionaryid)) {
            $mysqli = Service::connectToDB();
            $query = "DELETE FROM users_has_dictionaries WHERE users_userid = '$userid' AND dictionaries_dictionaryid = '$dictionaryid'";
            $mysqli->query($query);
            return true;
        }
        return false;
    }

    public function deleteDictionary($parameters): bool
    {
        $dictionaryid = $parameters[0];
        if (self::isDictionaryOwner($dictionaryid)) {
            $mysqli = Service::connectToDB();
            $query = "DELETE FROM dictionaries WHERE dictionaryid = '$dictionaryid'";
            $mysqli->query($query);
            return true;
        }
        return false;
    }

    public function getAllDictionaries()
    {
        $userid = Users::getUserId($_SESSION['username']);
        $mysqli = Service::connectToDB();
        $result = $mysqli->query("SELECT * FROM dictionaries WHERE ispublic = 1 AND dictionaryid !=
                                (SELECT
                                  users_has_dictionaries.dictionaries_dictionaryid
                                FROM users_has_dictionaries
                                    WHERE users_has_dictionaries.users_userid = '$userid' )");
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else return false;
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

    public static function isWordlistNameUsedExceptThis($wordlistName, $id): bool
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT name FROM dictionaries WHERE name = '$wordlistName' AND dictionaryid != '$id'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function checkWordlistName($wordlistName): bool
    {
        if (preg_match("/[^(\s\w\-\')]/u", $wordlistName) != 1 and Service::checkLength(4, 50, $wordlistName)) {
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

    public static function isDictionaryOwner($dictionaryid): bool
    {
        $username = $_SESSION['username'];
        $userid = Users::getUserId($username);
        $mysqli = Service::connectToDB();
        $result = $mysqli->query("SELECT * FROM dictionaries WHERE dictionaryowner = '$userid' AND dictionaryid = '$dictionaryid'")->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public function setTitle($id)
    {
        return self::getDictionaryName($id);
    }

    public function getWords($dictionaryID)
    {
        if (self::isUserHasADictionary($_SESSION['userid'], $dictionaryID)) {
            $data = Words::getWordsFromDictionary($dictionaryID);
            $data['dictionaryid'] = $dictionaryID;
            return $data;
        } else return 'Access denied.';
    }

    public function deleteWord($parameters)
    {

        $dictionaryid = $parameters[0];
        $wordid = $parameters[1];
        if (self::isDictionaryOwner($dictionaryid)) {
            $result = false;
            $mysqli = Service::connectToDB();
            $result = mysqli_query($mysqli, "DELETE FROM wordlist WHERE wordid = '$wordid'");
            $mysqli->close();
            return $result;
        }
        return false;
    }

    public function getFieldsContent($dictionaryId)
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT * FROM dictionaries WHERE dictionaryid = '$dictionaryId'";
        return $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}