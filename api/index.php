<?php
require __DIR__ . "\\bootstrap.php";
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$uri = RouteHelper::getRouteName();


if (str_contains($uri, '/product')) {
    ProductRoutes::getRoutes($uri, $_SERVER['REQUEST_METHOD']);

} elseif (str_contains($uri, '/feature')) {

    FeatureRoutes::getRoutes($uri, $_SERVER['REQUEST_METHOD']);

} else {

    header("HTTP/1.1 404 Not Found");
    echo json_encode(array("message" => "The page you were looking for was not found", "status" => "failure", "error" => "Not Found", "statusCode" => 404));
    exit();
}
