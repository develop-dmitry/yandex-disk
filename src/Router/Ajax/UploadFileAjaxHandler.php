<?php

namespace App\Router\Ajax;

use App\Router\Ajax\AjaxHandlerInterface;
use App\Storage\StorageBuilder;
use App\Helper\FileHelper;

class UploadFileAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        $result = [
            "result" => false,
            "message" => "Не удалось загрузить файл"
        ];
        if (isset($params["file"])) {
            $path = dirname($params["file"]["tmp_name"])."/".$params["file"]["name"];
            rename($params["file"]["tmp_name"], $path);
            if ($uploadedFile = StorageBuilder::getStorage()->uploadFile($path)) {
                $result = [
                    "result" => true,
                    "item" => $uploadedFile
                ];
            }
        }
        return $result;
    }
}