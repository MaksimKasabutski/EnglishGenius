<?php


class Profile
{

    public static function getUsersLists($username): array
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
                        WHERE users.username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result;
    }
}