<?php

namespace App\Router\Ajax;

use App\Storage\StorageBuilder;

class DownloadFileAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        $result = ["result" => false];
        if (isset($params["path"])) {
            if ($path = StorageBuilder::getStorage()->downloadFile($params["path"])) {
                $result = [
                    "result" => true,
                    "path" => $path
                ];
            } else {
                $result["message"] = "Не найден файл на диске";
            }
        } else {
            $result["message"] = "При выполнении запроса произошла ошибка";
        }
        return $result;
    }
}