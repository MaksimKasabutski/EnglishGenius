<?php


namespace Components;


class File
{
    private $data;
    private $path;
    private $filename;
    private $dir;

    public function __construct(?string $data = NULL)
    {
        $this->filename = $_SESSION['username'];
        $this->path = ROOT . '/learningFiles/' . $this->filename . '.txt';
        $this->data = $data;
        $this->dir = ROOT . '/learningFiles';

    }

    private function createDir()
    {
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777, true);
        }
    }

    public function createFile()
    {
        $this->createDir();
        return file_put_contents($this->path, $this->data);
    }


    public function getString($id)
    {
        $file = file($this->path);
        return isset($file[$id]) ? $file[$id] : NULL;
    }

    public function stringCount()
    {
        $file = file($this->path);
        return count($file);
    }

    public function changeString($id)
    {
        $array = file($this->path, FILE_IGNORE_NEW_LINES);
        $array[$id]  = $array[$id].'/1';
        file_put_contents($this->path, implode(PHP_EOL, $array));
    }
}