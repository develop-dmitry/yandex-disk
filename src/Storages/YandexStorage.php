<?php

namespace App\Storages;

use App\Helpers\EnvHelper;
use App\Storages\Exceptions\StorageException;
use App\Storages\Interfaces\StorageInterface;
use Arhitector\Yandex\Disk;
use Arhitector\Yandex\Disk\Resource\Closed;
use Exception;
use Symfony\Component\Dotenv\Exception\PathException;

class YandexStorage implements StorageInterface
{
    private Disk $storage;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        try {
            $token = EnvHelper::getInstance()->get("token");

            if (!$token) {
                throw new StorageException("Не указан API токен");
            }

            $this->storage = new Disk($token);
        } catch (PathException $exception) {
            throw new StorageException("Не найден .env файл");
        }
    }


    public function getFiles(int $limit = 20, int $offset = 0): array
    {
        $files = [];

        foreach ($this->storage->getResources($limit, $offset)->setSort("created", true) as $resource) {
            $files[] = $this->getFileArrFromResource($resource);
        }

        return $files;
    }

    public function uploadFile(string $path): bool
    {
        $resource = $this->storage->getResource(basename($path));

        return $resource->upload($path, true);
    }

    public function deleteFile(string $path): bool
    {
        return $this->storage->getResource($path)->delete(true);
    }

    public function downloadFile(string $path): false|string
    {
        $stream = fopen('php://temp', 'r+b');
        $resource = $this->storage->getResource($path);

        $resource->download($stream);
        rewind($stream);

        return stream_get_contents($stream);
    }

    public function renameFile(string $path, string $name): bool
    {
        $resource = $this->storage->getResource($path);

        if (!$resource->has()) {
            return false;
        }

        $newPath = dirname($path) . "/" . $name;

        try {
            return $resource->move($newPath);
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

    public function isFileExist(string $path): bool
    {
        $resource = $this->storage->getResource($path);

        return $resource->has();
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