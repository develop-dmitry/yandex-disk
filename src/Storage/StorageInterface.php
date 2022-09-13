<?php

namespace App\Storage;

interface StorageInterface
{
    public function getFiles();

    public function uploadFile(string $path);

    public function deleteFile(string $path);

    public function downloadFile(string $path);

    public function renameFile(string $path, string $name);

    public function getFilesCount();
}