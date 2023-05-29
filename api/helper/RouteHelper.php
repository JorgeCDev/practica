<?php

class RouteHelper
{

    public static function getRouteName()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        if (isset($uri[3]) && is_numeric($uri[3])) {
            $uri="/".$uri[2] ."/:id";
        } elseif(isset($uri[3])&&is_string($uri[3])) {
            $uri="/".$uri[2] ."/".$uri[3];
        }else {
            $uri="/".$uri[2];
        }

        return $uri;
    }

    public static function getKeyValues()
    {
        try {
            $q = htmlentities($_SERVER['QUERY_STRING']);
            parse_str(html_entity_decode($q), $arr);
            $arr = filter_var_array($arr, FILTER_SANITIZE_ENCODED);
            return $arr;

        } catch (Exception $e) {
            error_log($e->getMessage());
            return;
        }

    }

    public static function getBody() {
        $body = file_get_contents("php://input");
        $body = json_decode($body, true);
        return $body;
    }

    public static function getId() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = explode('/', $uri);
        return $uri[3];
    }

}
