<?php

namespace App\Ajax\Handlers;

use App\Ajax\Handlers\Interfaces\HandlerInterface;
use App\Storages\StorageBuilder;
use Exception;

class GetFilesHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        try {
            return [
                "result" => true,
                "items" => StorageBuilder::getStorage()->getFiles($params["limit"], $params["offset"])
            ];
        } catch (Exception $exception) {
            return [
                "result" => false,
                "message" => $exception->getMessage()
            ];
        }
    }
}