<?php
require_once('UserProvider.php');

class Security
{
    public static function generateRandomString($length = 8): string
    {
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= chr(mt_rand(40, 126));
        }
        return $string;
    }

    public static function encodePassword($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function checkPassword($username, $password): bool
    {
        $mysqli = UserProvider::connectToDB();
        $query = "SELECT password FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        $hash = $result[0]['password'];
        return password_verify($password, $hash);
    }

    public static function checkCookie(): bool
    {
        if (isset($_COOKIE['hash']) and isset($_SESSION['username'])) {
            $mysqli = UserProvider::connectToDB();
            $username = $_SESSION['username'];
            $query = "SELECT cookie FROM users WHERE username = '$username'";
            $userCookie = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
            $mysqli->close();
            if ($userCookie[0]['cookie'] == $_COOKIE['hash']) {
                return true;
            }
        }
        return false;
    }
}