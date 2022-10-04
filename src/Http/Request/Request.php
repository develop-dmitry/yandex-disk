<?php

namespace App\Http\Request;

class Request
{
    private array $data;

    public function __construct() {
        $this->data = $_GET;

        $post = json_decode(file_get_contents('php://input'), true);

        if ($post) {
            $this->data = array_merge($post, $this->data);
        }
    }

    public function getRequestType(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function getRequestUrl(): string
    {
        $url = explode("?", $_SERVER["REQUEST_URI"]);

        return $url[0];
    }

    public function isPost(): bool
    {
        return $this->getRequestType() === "post";
    }

    public function isGet(): bool
    {
        return $this->getRequestType() === "get";
    }

    public function setHeader(string $header): void
    {
        header($header);
    }

    public function get(string $name, mixed $default = ""): mixed
    {
        return (isset($this->data[$name])) ? $this->data[$name] : $default;
    }

    public function file(string $name, mixed $default = ""): mixed
    {
        return (isset($_FILES[$name])) ? $_FILES[$name] : $default;
    }
}