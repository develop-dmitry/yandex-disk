<?php

namespace App\Ajax\Handlers;

use App\Ajax\Handlers\Interfaces\HandlerInterface;
use App\Storages\StorageBuilder;
use Exception;

class DeleteFileHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        try {
            $result = ["result" => false];
            if (StorageBuilder::getStorage()->deleteFile($params["path"] ?? "")) {
                $result = ["result" => true];
            } else {
                $result = ["message" => "При удалении файла произошла ошибка"];
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