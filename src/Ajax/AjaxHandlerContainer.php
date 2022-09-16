<?php

namespace App\Ajax;


use App\Ajax\Handlers;

class AjaxHandlerContainer
{
    private array $handlers = [];
    private static AjaxHandlerContainer $container;

    private function __construct()
    {
        $this->addHandler(Handlers\GetFilesHandler::class, "get_files");
        $this->addHandler(Handlers\UploadFileHandler::class, "upload_file");
        $this->addHandler(Handlers\DownloadFileHandler::class, "download_file");
        $this->addHandler(Handlers\DeleteFileHandler::class, "delete_file");
        $this->addHandler(Handlers\GetFilePagesHandler::class, "get_file_pages");
        $this->addHandler(Handlers\ClearTmpHandler::class, "clear_tmp");
        $this->addHandler(Handlers\RenameFileHandler::class, "rename_file");
        $this->addHandler(Handlers\CheckFileExistHandler::class, "check_file_exist");
    }

    /**
     * Получает объект AjaxHandlerContainer
     *
     * @return AjaxHandlerContainer
     */
    public static function getInstance(): AjaxHandlerContainer
    {
        if (!isset(self::$container)) {
            self::$container = new AjaxHandlerContainer();
        }
        return self::$container;
    }

    /**
     * Добавляет новый обработчик в контейнер
     *
     * @param string $handler
     * @param string $name
     * @return void
     */
    public function addHandler(string $handler, string $name): void
    {
        if (!is_subclass_of($handler, "App\Ajax\Handlers\Interfaces\HandlerInterface")) {
            throw new \Exception("Некорректный обработчик запроса");
        }
        $this->handlers[$name] = $handler;
    }

    /**
     * Возвращает объект обработчика
     *
     * @param $name
     * @return \App\Ajax\Handlers\Interfaces\HandlerInterface|false
     */
    public function get($name): Handlers\Interfaces\HandlerInterface|false
    {
        return isset($this->handlers[$name]) ? new $this->handlers[$name]() : false;
    }
}