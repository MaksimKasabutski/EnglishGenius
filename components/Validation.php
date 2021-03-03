<?php
namespace Components;

class Validation
{
    public static function emailValidation($email):bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else return false;
    }

    public static function checkDictionaryName($dictionaryName): bool
    {
        if (preg_match("/[^(\s\w\-\')]/u", $dictionaryName) != 1 and self::checkLength(4, 50, $dictionaryName)) {
            return true;
        } else return false;
    }

    public static function isRus($string)
    {
        return preg_match("/[^(А-Яа-яЁё\s)]/u", $string);
    }

    public static function isEng($string)
    {
        return preg_match("/[^(A-Za-z\s)]/u", $string);
    }

    public static function checkLength($minlength, $maxlength, $string): bool
    {
        if (mb_strlen($string) < $minlength or mb_strlen($string) > $maxlength) {
            return false;
        } else return true;
    }

    public static function strCleaner($string): string
    {
        return mysqli_real_escape_string(DB::connectToDB(), htmlspecialchars(strip_tags(trim($string, " \n\r\t\v\0"))));
    }

    public static function wordValidation($engWord, $rusWord)
    {
        if (Validation::isEng($engWord)) {
            $response = new Response('error', 'Wrong english word');
            return $response;
        } elseif (Validation::isRus($rusWord)) {
            $response = new Response('error', 'Wrong translation');
            return $response;
        } elseif (!Validation::checkLength(1, 25, $engWord) or !Validation::checkLength(1, 25, $rusWord)) {
            $response = new Response('error', 'The words must be from 1 to 25 symbols.');
            return $response;
        }
        return NULL;
    }
}