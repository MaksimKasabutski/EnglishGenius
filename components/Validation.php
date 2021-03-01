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
        if (preg_match("/[^(\s\w\-\')]/u", $dictionaryName) != 1 and Service::checkLength(4, 50, $dictionaryName)) {
            return true;
        } else return false;
    }
}