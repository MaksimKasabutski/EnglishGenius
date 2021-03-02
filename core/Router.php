<?php

namespace Core;

use Controllers\{AuthregAPIController, AuthregController, DictionaryController, DictionaryAPIController,
    WordAPIController, WordController, ProfileController};

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT . '/core/routes.php';
        $this->routes = require($routesPath);
    }

    private function getURI()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }

    public function run()
    {
        $uri = $this->getURI();
        if(empty($uri)) {
            $uri = 'login';
        }
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);

                $controllerName = "Controllers\\" . ucfirst(array_shift($segments) . 'Controller');
                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                $controllerObject = new $controllerName($parameters);
                $controllerObject->$actionName($parameters);

                if ($controllerObject != null) {
                    break;
                }
            }
        }
        if (!isset($controllerObject)) {
            $controllerObject = new Controller();
            $controllerObject->action404();
        }
    }
}