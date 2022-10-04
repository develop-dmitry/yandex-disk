<?php

use App\Http\Router\Router;
use App\Controllers;

$router = new Router();

$router->get("/", [Controllers\HomeController::class, "index"]);
$router->get("/download", [Controllers\FileController::class, "downloadFile"]);
$router->post("/api/check-file-exist", [Controllers\FileController::class, "checkFileExist"]);
$router->post("/api/delete-file", [Controllers\FileController::class, "deleteFile"]);
$router->post("/api/get-file-pages", [Controllers\FileController::class, "getFilePages"]);
$router->post("/api/get-files", [Controllers\FileController::class, "getFiles"]);
$router->post("/api/rename-file", [Controllers\FileController::class, "renameFile"]);
$router->post("/api/upload-file", [Controllers\FileController::class, "uploadFile"]);