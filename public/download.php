<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/functions.php";

use App\Storages\StorageBuilder;

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=" . basename($_GET["path"]));

echo StorageBuilder::getStorage()->downloadFile($_GET["path"]);