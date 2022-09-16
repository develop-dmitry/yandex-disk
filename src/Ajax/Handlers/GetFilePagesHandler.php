<?php

namespace App\Ajax\Handlers;

use App\Ajax\Handlers\Interfaces\HandlerInterface;
use App\Storages\StorageBuilder;
use Exception;

class GetFilePagesHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        try {
            return [
                "result" => true,
                "pages" => ceil(StorageBuilder::getStorage()->getFilesCount() / $params["limit"])
            ];
        } catch (Exception $exception) {
            return [
                "result" => false,
                "message" => $exception->getMessage()
            ];
        }
    }
}