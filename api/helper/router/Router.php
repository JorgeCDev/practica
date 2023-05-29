<?php
require PROJECT_ROOT_PATH . "helper\\router\Route.php";
class Router
{
    private $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute($url, $method, $handler)
    {
        $this->routes[] = new Route($url, $method, $handler);
    }

    public function handleRequest($url, $method)
    {
        foreach ($this->routes as $route) {
            if ($route->getUrl() === $url && $route->getMethod() === $method) {
                $handler = $route->getHandler();
                if (is_callable($handler)) {
                    call_user_func($handler);
                } else {
                    echo "Invalid handler for route: $url";
                }
                return;
            }
        }
        echo "Route not found: $url";
    }
}
?>

