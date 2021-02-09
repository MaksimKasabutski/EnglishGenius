<?php


class Service
{
    public static function connectToDB(): object
    {
        $mysqli = new mysqli('localhost', 'root', '1234', 'EnglishGenius');
        return $mysqli;
    }

    public static function isStringRussian($string)
    {
        return preg_match("/[^(А-Яа-яЁё)]/u", $string);
    }

    public static function checkLength($minlength, $maxlength, $string): bool
    {
        if (mb_strlen($string) < $minlength or mb_strlen($string) > $maxlength) {
            return false;
        } else return true;
    }

    public static function strCleaner($string): string
    {
        return htmlspecialchars(strip_tags(trim($string, " \n\r\t\v\0")));
    }

    public static function isStringEnglish($string)
    {
        return preg_match("/[^(A-Za-z\')]/u", $string);
    }

}