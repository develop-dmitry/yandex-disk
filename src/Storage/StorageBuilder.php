<?php

namespace App\Storage;

use App\Helper\EnvHelper;

class StorageBuilder
{
    private static StorageInterface $storage;

    public static function getStorage(): StorageInterface|null
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
        return EnvHelper::getInstance()->get("storage_type");
    }
}