<?php

require_once __DIR__."/functions.php";

use App\Router\AjaxRouter;

$request = array_merge($_REQUEST, $_FILES);

echo AjaxRouter::run($request);