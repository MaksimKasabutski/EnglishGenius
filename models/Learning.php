<?php


namespace Models;


use Components\File;

class Learning
{
    private $method;
    private $dictionaryid;
    private $learningFile;

    public function __construct($parameters = NULL)
    {
        $this->method = $parameters[0];
        $this->dictionaryid = $_SESSION['dictionaryId'];
        $this->learningFile = new File($this->setData());
    }

    public function createFile()
    {
        $this->learningFile->createFile();
    }

    public function getArray($stringid)
    {
        $array = $this->stringToArray($stringid);
        $array['count'] = $this->learningFile->stringCount();
        return $array;
    }

    public function setData()
    {
        $data = Words::getAllWords();
        if($this->method == 're') {
            $data = $this->changeWords($data);
        }
        return $this->arrayToString($data);
    }

    public function getTitle()
    {
        $title = 'Learning - ' . Dictionary::getDictionaryName($this->dictionaryid);
        return $title;
    }

    private function stringToArray($id)
    {
        $string = $this->learningFile->getString($id);
        return explode('/', $string);
    }

    private function arrayToString($array)
    {
        shuffle($array);
        $string = '';
        foreach ($array as $elem) {
            $string .= implode('/', $elem) . "\r\n";
        }
        return $string;
    }

    private function changeWords($data)
    {
        foreach($data as &$elem) {
            $temp = $elem['translation'];
            $elem['translation'] = $elem['word'];
            $elem['word'] = $temp;
        }
        return $data;
    }
}