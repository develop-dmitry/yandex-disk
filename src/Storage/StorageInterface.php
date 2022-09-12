<?php

namespace App\Storage;

interface StorageInterface
{
    public function getFiles();
    public function uploadFile(string $path);
    public function deleteFile();
    public function downloadFile();
}