<?php


namespace Controllers;

use Components\File;
use Components\LearningResponse;
use Components\Response;
use Models\Learning;

class LearningAPIController extends \Core\APIController
{
    private $word;
    private $translation;
    private $counter;

    public function __construct()
    {
        parent::__construct();
        $this->word = isset($this->request['word']) ? $this->request['word'] : NULL;
        $this->translation = isset($this->request['translation']) ? $this->request['translation'] : NULL;
        $this->counter = $this->request['counter'];
    }

    public function actionCheck()
    {
        $model = new Learning();
        $array = $model->getArray($this->counter);
        if ($array[1] == $this->translation) {
            $response = new Response('success', NULL);
            $file = new File();
            $file->changeString($this->counter);
        } else $response = new Response('error', NULL);
        echo json_encode($response);
    }

    public function actionNext()
    {
        $model = new Learning();
        $array = $model->getArray($this->counter);
        $response = new LearningResponse($array[0], $array[1], trim($array[2]), isset($array[3]) ? trim($array[3]) : NULL);
        echo json_encode($response);
    }
}