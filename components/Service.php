<?php
namespace Components;
use Mysqli;

class Service
{
    public static function connectToDB(): mysqli
    {
        return new mysqli(HOST, USER, PASSWORD, DBNAME);
    }

    public static function checkLength($minlength, $maxlength, $string): bool
    {
        if (mb_strlen($string) < $minlength or mb_strlen($string) > $maxlength) {
            return false;
        } else return true;
    }

    public static function strCleaner($string): string
    {
        return mysqli_real_escape_string(self::connectToDB(), htmlspecialchars(strip_tags(trim($string, " \n\r\t\v\0"))));
    }

    public static function isRus($string)
    {
        return preg_match("/[^(А-Яа-яЁё)]/u", $string);
    }

    public static function isEng($string)
    {
        return preg_match("/[^(A-Za-z\'\s)]/u", $string);
    }

}