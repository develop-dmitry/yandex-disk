<?php

namespace App\Router\Ajax;

use App\Storage\StorageBuilder;

class RenameFileAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        if (isset($params["path"]) && isset($params["name"])) {
            return ["result" => StorageBuilder::getStorage()->renameFile($params["path"], $params["name"])];
        }
        return ["result" => true];
    }
}