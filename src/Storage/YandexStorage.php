<?php

namespace App\Storage;

use App\Helper\EnvHelper;
use App\Helper\FileHelper;
use Arhitector\Yandex\Disk\Resource\Closed;
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


    public function getFiles(int $limit = 20, int $offset = 0): array
    {
        $files = [];
        foreach ($this->storage->getResources($limit, $offset)->setSort("created", true) as $resource) {
            $files[] = $this->getFileArrFromResource($resource);
        }
        return $files;
    }

    public function uploadFile(string $path): array|false
    {
        $resource = $this->storage->getResource(basename($path));
        return ($resource->upload($path, true)) ? $this->getFileArrFromResource($resource) : false;
    }

    public function deleteFile(string $path): bool
    {
        return $this->storage->getResource($path)->delete(true);
    }

    public function downloadFile(string $path): string|false
    {
        $resource = $this->storage->getResource($path);
        if (!$resource->has()) {
            return false;
        }

        $path = FileHelper::getTmpPath() . "/" . $resource->get("name");
        if ($resource->download($_SERVER["DOCUMENT_ROOT"] . $path, true) !== false) {
            return $path;
        }

        return false;
    }

    public function renameFile(string $path, string $name): array|false
    {
        $resource = $this->storage->getResource($path);
        if (!$resource->has()) {
            return false;
        }

        $newPath = dirname($path) . "/" . $name;
        try {
            $resource->move($newPath);
            return $this->getFileArrFromResource($resource);
        } catch (Exception $exception) {
            return false;
        }
    }

    public function getFilesCount(): int
    {
        $count = 0;
        while (($currentCount = $this->storage->getResources(20, $count)->count()) > 0) {
            $count += $currentCount;
        }
        return $count;
    }

    /**
     * Получает массив из объекта Closed
     *
     * @param Closed $resource
     * @return array
     */
    private function getFileArrFromResource(Closed $resource): array
    {
        $file = $resource->toArray();
        return [
            "name" => $file["name"],
            "path" => $file["path"],
            "created" => date("d.m.Y H:i:s", strtotime($file["created"]))
        ];
    }
}