<?php
require_once ROOT . '/components/Service.php';
require_once ROOT . '/models/Users.php';
require_once ROOT . '/models/Words.php';

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
        $result = mysqli_query($mysqli, "INSERT INTO dictionaries(dictionaryid, name, discription, dictionaryowner, ispublic) VALUES(NULL, '$wordlistName', '$wordlistDiscription', '$userid', '$isPublic')");
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
        return self::getWordlistName($id);
    }

    public function getWords($dictionaryid): string
    {
        if (self::isUserHasADictionary($_SESSION['userid'], $dictionaryid)) {
            $words = Words::getWordsFromDictionary($dictionaryid);
            $result = "<div class='col-sm-4'><table class='table table-inverse'><tr><th>English word</th><th>Translation</th></tr>";
            foreach ($words as $wordpare) {
                $result .= "<tr><td>" . $wordpare['word'] . "</td><td>" . $wordpare['translation'] . "</td>";
                if (self::isDictionaryOwner($dictionaryid)) {
                    $result .= "<td><a href='" . $dictionaryid . "/" . $wordpare['wordid'] . "' >DEL</a></td>";
                }
                $result .= "</tr>";
            }
            $result .= "</table></div>";
            return $result;
        } else return 'error';
    }

    public function deleteWord($parameters)
    {

        $dictionaryid = $parameters[0];
        $wordid = $parameters[1];
        if(self::isDictionaryOwner($dictionaryid)) {
            $result = false;
            $mysqli = Service::connectToDB();
            $result = mysqli_query($mysqli, "DELETE FROM wordlist WHERE wordid = '$wordid'");
            $mysqli->close();
            return $result;
        }
        return false;
    }
}