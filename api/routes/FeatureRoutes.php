<?php
require_once PROJECT_ROOT_PATH . "helper\\router\Router.php";
require_once PROJECT_ROOT_PATH . "controller\FeatureController.php";

class FeatureRoutes
{
    public static function getRoutes($url, $method)
    {
        
        $router = new Router();
        $controller = new FeatureController();
        $router->addRoute("/feature", "GET", array($controller, "All"));
        $router->addRoute("/feature/:id", "GET", array($controller, "getById"));
        $router->addRoute("/feature", "POST", array($controller, "create"));
        $router->addRoute("/feature/:id", "PUT", array($controller, "update"));
        $router->addRoute("/feature/:id", "DELETE", array($controller, "remove"));

        return $router->handleRequest($url, $method);
    }

}
?>