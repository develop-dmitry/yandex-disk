<?php

namespace App\Storage;

use Symfony\Component\Dotenv\Dotenv;

class StorageBuilder
{
    private static StorageInterface $storage;

    public static function getStorage(): StorageInterface | null
    {
        if (!isset(self::$storage)) {
            self::createStorage();
        }
        return self::$storage;
    }

    private static function createStorage(): void
    {
        switch (self::getStorageType()) {
            case "yandex":
                self::$storage = new YandexStorage();
                break;
        }
    }

    private static function getStorageType(): string
    {
        return "yandex";
    }
}