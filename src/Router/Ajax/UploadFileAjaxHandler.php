<?php

namespace App\Router\Ajax;

use App\Router\Ajax\AjaxHandlerInterface;
use App\Storage\StorageBuilder;
use App\Helper\FileHelper;

class UploadFileAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        if (isset($params["file"])) {
            if ($path = $this->uploadFile($params["file"])) {
                StorageBuilder::getStorage()->uploadFile($path);
            }
        }
    }

    private function uploadFile(array $file): string|false
    {
        return FileHelper::getInstance()->uploadFile($file);
    }
}