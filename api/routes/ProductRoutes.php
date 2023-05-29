<?php
require_once PROJECT_ROOT_PATH . "helper\\router\Router.php";
require_once PROJECT_ROOT_PATH . "controller\ProductController.php";

class ProductRoutes
{
    public static function getRoutes($url, $method)
    {
       
        $router = new Router();
        $controller = new ProductController();
        $router->addRoute("/product", "GET", array($controller, "All"));
        $router->addRoute("/product/category", "GET", array($controller, "category"));
        $router->addRoute("/product/:id", "GET", array($controller, "getById"));
        $router->addRoute("/product", "POST", array($controller, "create"));
        $router->addRoute("/product/:id", "PUT", array($controller, "update"));
        $router->addRoute("/product/:id", "DELETE", array($controller, "remove"));
        

        return $router->handleRequest($url, $method);
    }





}
?>

