<?php

namespace App\Helper;

class FileHelper
{
    private static string $tmpPath = "/uploads/tmp";

    /**
     * Очищает папку с временными файлами
     *
     * @return void
     */
    public static function clearTmp(): void
    {
        $files = glob($_SERVER["DOCUMENT_ROOT"] . self::$tmpPath . "/*");
        foreach ($files as $file) {
            unlink($file);
        }
    }

    /**
     * Получает путь до директории с временными файлами
     *
     * @return string
     */
    public static function getTmpPath(): string
    {
        if (!self::isExistTmpPath()) {
            self::createTmpDirectory();
        }
        return self::$tmpPath;
    }

    /**
     * Создает директорию с временными файлами
     *
     * @return void
     */
    private static function createTmpDirectory(): void
    {
        $directories = explode("/", self::$tmpPath);
        $path = $_SERVER["DOCUMENT_ROOT"];
        foreach ($directories as $directory) {
            $path .= "/".$directory;
            if (!file_exists($path)) {
                mkdir($path);
            }
        }
    }

    /**
     * Проверяет наличие папки для временных файлов
     *
     * @return bool
     */
    private static function isExistTmpPath(): bool
    {
        return file_exists($_SERVER["DOCUMENT_ROOT"] . self::$tmpPath);
    }
}