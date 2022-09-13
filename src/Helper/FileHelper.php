<?php

namespace App\Helper;

class FileHelper
{
    private static string $imagesTmpPath = "/uploads/tmp";

    public static function clearTmp(): void
    {
        $files = glob($_SERVER["DOCUMENT_ROOT"].self::$imagesTmpPath."/*");
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public static function getTmpPath(): string
    {
        if (!file_exists($_SERVER["DOCUMENT_ROOT"].self::$imagesTmpPath)) {
            mkdir($_SERVER["DOCUMENT_ROOT"].self::$imagesTmpPath);
        }
        return self::$imagesTmpPath;
    }
}