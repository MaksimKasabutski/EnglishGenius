<?php


namespace Models;


class Learning
{
    private $method;
    private $dictionaryid;

    public function __construct($parameters)
    {
        $this->method = $parameters[0];
        $this->dictionaryid = $_SESSION['dictionaryId'];
    }

    public function getData()
    {
        return Words::getAllWords();
    }

    public function getTitle()
    {
        $title = 'Learning - ' . Dictionary::getDictionaryName($this->dictionaryid);
        return $title;
    }

}