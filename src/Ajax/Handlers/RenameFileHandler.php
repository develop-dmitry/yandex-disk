<?php

namespace App\Ajax\Handlers;

use App\Storage\StorageBuilder;
use \Exception;

class RenameFileHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        try {
            if (isset($params["path"]) && isset($params["name"])) {
                return ["result" => StorageBuilder::getStorage()->renameFile($params["path"], $params["name"])];
            }
            return ["result" => true];
        } catch (Exception $exception) {
            return [
                "result" => false,
                "message" => $exception->getMessage()
            ];
        }
    }
}