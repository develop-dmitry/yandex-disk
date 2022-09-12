<?php

namespace App\Helper;

class FileHelper
{
    private static FileHelper $helper;
    private string $filePath;

    private function __construct()
    {
        $this->filePath = dirname($_SERVER["DOCUMENT_ROOT"], 1) . "/storage/uploads/";
    }

    public static function getInstance(): FileHelper
    {
        if (!isset(self::$helper)) {
            self::$helper = new FileHelper();
        }
        return self::$helper;
    }

    public function uploadFile(array $file): string|false
    {
        $newPath = $this->filePath . basename($file["name"]);
        return (move_uploaded_file($file["tmp_name"], $newPath)) ? $newPath : false;
    }
}