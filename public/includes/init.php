<?php

use App\Helpers\EnvHelper;
use App\Http\Request\Request;
use Symfony\Component\Dotenv\Exception\PathException;

require_once "constants.php";
require_once PROJECT_PATH . "/vendor/autoload.php";
require_once "web.php";

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic');
    header('HTTP/1.0 401 Unauthorized');
    die("Авторизация отменена");
}

try {
    $envHelper = EnvHelper::getInstance();

    if ($_SERVER["PHP_AUTH_USER"] !== $envHelper->get("login") || $_SERVER["PHP_AUTH_PW"] !== $envHelper->get("password")) {
        die("Вы ввели неверный пароль");
    }
} catch (PathException $exception) {
    exit($exception->getMessage());
}

$request = new Request();