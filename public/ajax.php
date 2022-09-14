<?php

require_once __DIR__."/functions.php";

use App\Ajax\Ajax;

$request = array_merge($_REQUEST, $_FILES);

echo Ajax::run($request);
die();