<?php

namespace App\Ajax\Handlers;

use App\Ajax\Handlers\Interfaces\HandlerInterface;
use App\Storages\StorageBuilder;
use Exception;

class DownloadFileHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        try {
            $result = ["result" => false];
            if ($path = StorageBuilder::getStorage()->downloadFile($params["path"] ?? "")) {
                $result = [
                    "result" => true,
                    "path" => $path
                ];
            } else {
                $result["message"] = "Не найден файл на диске";
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