<?php

namespace App\Ajax\Handlers;

use App\Ajax\Handlers\Interfaces\HandlerInterface;
use App\Storages\StorageBuilder;
use Exception;

class CheckFileExistHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        try {
            $result = ["result" => StorageBuilder::getStorage()->isFileExist($params["path"] ?? "")];
            if (!$result["result"]) {
                $result = ["message" => "Файл не найден"];
            }
            return $result;
        } catch (Exception $exception) {
            return [
                "result" => false,
                "message" => $exception->getMessage()
            ];
        }
    }
}