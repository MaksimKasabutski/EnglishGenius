<?php


class Validation
{
    public static function emailValidation($email):bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else return false;
    }
}