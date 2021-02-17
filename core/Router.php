<?php


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
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        $uri = trim($this->getURI(), '/') . '/';

        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~", $uri)) {

                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($segments) . 'Controller');
                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerObject = new $controllerName;
                $controllerObject->$actionName($parameters);

                if($controllerObject != null) {
                    break;
                }
            }
        }
    }
}