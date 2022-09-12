<?php

namespace App\Router\Ajax;

use App\Storage\StorageBuilder;

class GetFilesAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        return [
            "result" => true,
            "items" => StorageBuilder::getStorage()->getFiles()
        ];
    }
}