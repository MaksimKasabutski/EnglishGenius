<?php
namespace Components;

class Security
{
    public static function encodePassword($password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function checkPassword($username, $password): bool
    {
        $mysqli = DB::connectToDB();
        $query = "SELECT password FROM users WHERE username = '$username'";
        $result = $mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
        $mysqli->close();
        $hash = $result[0]['password'];
        return password_verify($password, $hash);
    }

}