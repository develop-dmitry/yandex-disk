<?php

namespace App\Storage;

use App\Helper\EnvHelper;
use Exception;

class StorageBuilder
{
    private static StorageInterface $storage;

    /**
     * Получает объект StorageInterface
     *
     * @return StorageInterface
     * @throws Exception
     */
    public static function getStorage(): StorageInterface
    {
        if (!isset(self::$storage)) {
            self::createStorage();
        }
        return self::$storage;
    }

    /**
     * Создает объект StorageInterface
     *
     * @return void
     * @throws Exception
     */
    private static function createStorage(): void
    {
        if ($storageType = self::getStorageType()) {
            self::$storage = match ($storageType) {
                "yandex" => new YandexStorage(),
                default => throw new Exception("Не удалось определить тип хранилища"),
            };
        }
    }

    /**
     * Получает тип хранилища
     *
     * @return string|false
     */
    private static function getStorageType(): string|false
    {
        return EnvHelper::getInstance()->get("storage_type");
    }
}