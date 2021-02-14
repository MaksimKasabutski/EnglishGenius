<?php
require_once(ROOT . '/components/Service.php');
require_once(ROOT . '/components/Security.php');

class Users
{

    public static function isAlreadyLogin(): bool
    {
        if (isset($_SESSION['username'])) {
            return true;
        }
        return false;
    }

    public static function getUserId($username)
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT userid FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result[0]['userid'];
    }

    public static function isUsernameUsed($username): bool
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function isEmailUsed($email): bool
    {
        $mysqli = Service::connectToDB();
        $query = "SELECT email FROM users WHERE email = '$email'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function checkUserName($username): bool
    {
        $username = htmlspecialchars(trim($username, " \n\r\t\v\0"));
        if (Service::checkLength(4, 16, $username)) {
            return false;
        }
        if (preg_match("/[^(\s\w\-)]/u", $username) == 1) {
            return false;
        }
        return true;
    }

    public static function addUser($username, $email, $password): bool
    {
        $mysqli = Service::connectToDB();
        $result = mysqli_query($mysqli, "INSERT INTO users VALUES(NULL, '$username', '$email', '$password')");
        $mysqli->close();
        return $result;
    }
}