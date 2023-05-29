<?php
class Route
{
    private $url;
    private $method;
    private $handler;

    public function __construct($url, $method, $handler)
    {
        $this->url = $url;
        $this->method = $method;
        $this->handler = $handler;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getHandler()
    {
        return $this->handler;
    }
}

?>
