<?php

namespace App\Router\Ajax;


class AjaxHandlerContainer
{
    private array $handlers = [];
    private static AjaxHandlerContainer $container;

    private function __construct()
    {
        $this->addHandler(GetFilesAjaxHandler::class, "get_files");
        $this->addHandler(UploadFileAjaxHandler::class, "upload_file");
    }

    public static function getInstance(): AjaxHandlerContainer
    {
        if (!isset(self::$container)) {
            self::$container = new AjaxHandlerContainer();
        }
        return self::$container;
    }

    public function addHandler(string $handler, string $name): void
    {
        if (is_subclass_of($handler, "App\Router\Ajax\AjaxHandlerInterface")) {
            $this->handlers[$name] = $handler;
        }
    }

    public function get($name): AjaxHandlerInterface|false
    {
        return isset($this->handlers[$name]) ? new $this->handlers[$name]() : false;
    }
}