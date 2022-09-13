<?php

namespace App\Router\Ajax;

use App\Storage\StorageBuilder;

class GetFilePagesAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        return [
            "result" => true,
            "pages" => ceil(StorageBuilder::getStorage()->getFilesCount() / $params["limit"])
        ];
    }
}