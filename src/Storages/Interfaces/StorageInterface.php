<?php

namespace App\Storages\Interfaces;

interface StorageInterface
{
    /**
     * Получает массив файлов из хранилища
     *
     * @return array
     */
    public function getFiles(): array;

    /**
     * Загружает файл в хранилище
     *
     * @param string $path
     * @return array|false
     */
    public function uploadFile(string $path): array|false;

    /**
     * Удаляет файл из хранилища
     *
     * @param string $path
     * @return bool
     */
    public function deleteFile(string $path): bool;

    /**
     * Скачивает файл из хранилища
     *
     * @param string $path
     * @return string|false
     */
    public function downloadFile(string $path): string|false;

    /**
     * Переименовывает файл по указанному пути
     *
     * @param string $path
     * @param string $name
     * @return array|false
     */
    public function renameFile(string $path, string $name): array|false;

    /**
     * Получает количество файлов в хранилище
     *
     * @return int
     */
    public function getFilesCount(): int;

    /**
     * Проверка наличия файла в хранилище
     *
     * @return bool
     */
    public function isFileExist(string $path): bool;
}