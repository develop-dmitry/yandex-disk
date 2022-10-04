<?php

namespace App\Controllers;

use App\Http\Response\Response;
use App\Http\Response\View;
use App\Storages\StorageBuilder;
use App\Http\Response\Text;

class FileController extends Controller
{
    /**
     * Проверка наличия файла в хранилище
     *
     * @return Response
     */
    public function checkFileExist(): Response
    {
        $response = new Response();

        try {
            $storage = StorageBuilder::getStorage();

            $isExist = $storage->isFileExist($this->request->get("path") ?? "");
            $response->setSuccess($isExist);

            if (!$isExist) {
                $response->setMessage("Файл не найден");
            }
        } catch (\Exception $exception) {
            $response->setSuccess(false);
            $response->setMessage($exception->getMessage());
        }

        return $response;
    }

    /**
     * Удаление файла из хранилища
     *
     * @return Response
     */
    public function deleteFile(): Response
    {
        $response = new Response();

        try {
            $storage = StorageBuilder::getStorage();

            $isDelete = $storage->deleteFile($this->request->get("path") ?? "");
            $response->setSuccess($isDelete);

            if (!$isDelete) {
                $response->setMessage("При удалении файла произошла ошибка");
            }
        } catch (\Exception $exception) {
            $response->setSuccess(false);
            $response->setMessage($exception->getMessage());
        }

        return $response;
    }

    /**
     * Получение количества страниц
     *
     * @return Response
     */
    public function getFilePages(): Response
    {
        $response = new Response();

        try {
            $storage = StorageBuilder::getStorage();

            $response->setSuccess(true);
            $response->addResponse("pages", ceil($storage->getFilesCount() / $this->request->get("limit")));
        } catch (\Exception $exception) {
            $response->setSuccess(false);
            $response->setMessage($exception->getMessage());
        }

        return $response;
    }

    /**
     * Получение файлов хранилища
     *
     * @return Response
     */
    public function getFiles(): Response
    {
        $response = new Response();

        try {
            $storage = StorageBuilder::getStorage();
            $limit = (int) $this->request->get("limit");
            $offset = (int) $this->request->get("offset");

            $response->setSuccess(true);
            $response->addResponse("items", $storage->getFiles($limit, $offset));
        } catch (\Exception $exception) {
            $response->setSuccess(false);
            $response->setMessage($exception->getMessage());
        }

        return $response;
    }

    /**
     * Изменение имени файла в хранилище
     *
     * @return Response
     */
    public function renameFile(): Response
    {
        $response = new Response();

        try {
            $storage = StorageBuilder::getStorage();

            $isRename = $storage->renameFile($this->request->get("path"), $this->request->get("name"));
            $response->setSuccess($isRename);

            if (!$isRename) {
                $response->setMessage("При переименовывании файла произошла ошибка");
            }
        } catch (\Exception $exception) {
            $response->setSuccess(false);
            $response->setMessage($exception->getMessage());
        }

        return $response;
    }

    /**
     * Загрузка файла в хранилище
     *
     * @return Response
     */
    public function uploadFile(): Response
    {
        $response = new Response();

        try {
            $storage = StorageBuilder::getStorage();

            $file = $this->request->file("file");
            $path = dirname($file["tmp_name"]) . "/" . $file["name"];
            rename($file["tmp_name"], $path);

            $isUpload = $storage->uploadFile($path);
            $response->setSuccess($isUpload);

            if (!$isUpload) {
                $response->setMessage("При загрузке файла произошла ошибка");
            }
        } catch (\Exception $exception) {
            $response->setSuccess(false);
            $response->setMessage($exception->getMessage());
        }

        return $response;
    }

    /**
     * Скачивание файла из хранилища
     *
     * @return mixed
     */
    public function downloadFile(): mixed
    {
        try {
            $storage = StorageBuilder::getStorage();
            $path = $this->request->get("path");

            $this->request->setHeader("Content-Type: application/octet-stream");
            $this->request->setHeader("Content-Disposition: attachment; filename=" . basename($path));

            $response = new Text($storage->downloadFile($path));
        } catch (\Exception $exception) {
            $view = new View("error.php");
            $response = $view();
        }

        return $response;
    }
}