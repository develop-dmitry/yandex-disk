<?php

namespace App\Ajax\Handlers;

use App\Storage\StorageBuilder;
use \Exception;

class UploadFileHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        try {
            $result = [
                "result" => false,
                "message" => "Не удалось загрузить файл"
            ];
            if (isset($params["file"])) {
                $path = dirname($params["file"]["tmp_name"]) . "/" . $params["file"]["name"];
                rename($params["file"]["tmp_name"], $path);
                if ($uploadedFile = StorageBuilder::getStorage()->uploadFile($path)) {
                    $result = [
                        "result" => true,
                        "item" => $uploadedFile
                    ];
                }
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