<?php

namespace App\Storage;

use App\Helper\EnvHelper;
use Arhitector\Yandex\Client\OAuth;
use Arhitector\Yandex\Disk;
use Exception;

class YandexStorage implements StorageInterface
{
    private Disk $storage;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $token = EnvHelper::getInstance()->get("token");
        if (!$token) {
            throw new Exception("Не удалось прочитать API токен");
        }

        $this->storage = new Disk($token);
    }

    public function getFiles(): array
    {
        return $this->getFilesFromDir("/");
    }

    private function getFilesFromDir(string $path): array
    {
        $files = [];
        foreach ($this->storage->getResource($path)->items as $file) {
            $file = $file->toArray();
            if ($file["type"] == "dir") {
                $files = array_merge($files, $this->getFilesFromDir($file["path"]));
            } else {
                $files[] = [
                    "name" => $file["name"],
                    "path" => $file["path"],
                    "created" => date("d.m.Y H:i:s", strtotime($file["created"]))
                ];
            }
        }
        return $files;
    }

    public function uploadFile(string $path): array
    {
        $resources = $this->storage->getResource("/");
        $resources->upload($path);
        return [];
    }

    public function deleteFile()
    {
        // TODO: Implement deleteFile() method.
    }

    public function downloadFile()
    {
        // TODO: Implement downloadFile() method.
    }
}