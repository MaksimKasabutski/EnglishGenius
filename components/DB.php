<?php
namespace Components;
use Mysqli;

class DB
{
    public static function connectToDB(): mysqli
    {
        return new mysqli(HOST, USER, PASSWORD, DBNAME);
    }

}