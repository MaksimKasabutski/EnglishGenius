<?php

class UserProvider
{
    public static function connectToDB(): object
    {
        $mysqli = new mysqli('localhost', 'root', '1234', 'EnglishGenius');
        return $mysqli;
    }

    public static function getUser($username): bool
    {
        $mysqli = self::connectToDB();
        $query = "SELECT username FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        if (empty($result)) {
            return false;
        } else return true;
    }

    public static function getUserId($username)
    {
        $mysqli = self::connectToDB();
        $query = "SELECT userid FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        return $result[0]['userid'];
    }

    public static function isEmailUsed($email): bool
    {
        $mysqli = self::connectToDB();
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
        if (empty($username) or preg_match("/[^(А-Яа-яёЁ\s\w\-)]/u", $username) == 1 or mb_strlen($username) < 4 or mb_strlen($username) > 16) {
            return false;
        } else return true;
    }

    public static function addUser($username, $email, $password, $cookie): bool
    {
        $mysqli = self::connectToDB();
        $result = mysqli_query($mysqli, "INSERT INTO users VALUES(NULL, '$username', '$email', '$password', '$cookie')");
        $mysqli->close();
        return $result;
    }

    public static function addCookieToUser($username, $cookie)
    {
        $query = "UPDATE users SET cookie = '$cookie' WHERE username = '$username'";
        $mysqli = self::connectToDB();
        $mysqli->query($query);
        $mysqli->close();
    }
}