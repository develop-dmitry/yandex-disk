<?php

namespace App\Storage;

interface StorageInterface
{
    public function getFiles();
    public function uploadFile();
    public function deleteFile();
    public function downloadFile();
}