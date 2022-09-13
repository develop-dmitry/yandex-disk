<?php

namespace App\Router\Ajax;

use App\Storage\StorageBuilder;

class DeleteFileAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        $result = ["result" => false];
        if (isset($params["path"])) {
            if (StorageBuilder::getStorage()->deleteFile($params["path"])) {
                $result = ["result" => true];
            } else {
                $result = ["message" => "При удалении файла произошла ошибка"];
            }
        } else {
            $result = ["message" => "Файла не существует"];
        }
        return $result;
    }
}