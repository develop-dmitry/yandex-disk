<?php

namespace App\Storages\Interfaces;

interface StorageInterface
{
    /**
     * Получает массив файлов из хранилища
     *
     * @return array
     */
    public function getFiles(int $limit = 20, int $offset = 0): array;

    /**
     * Загружает файл в хранилище
     *
     * @param string $path
     * @return bool
     */
    public function uploadFile(string $path): bool;

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
     * @return bool
     */
    public function renameFile(string $path, string $name): bool;

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