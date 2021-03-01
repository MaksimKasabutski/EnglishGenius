<?php
namespace Core;

class APIController
{
    protected $request;

    public function __construct()
    {
        $this->request = json_decode(file_get_contents('php://input'), true);
    }
}