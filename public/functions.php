<?php

require_once "../vendor/autoload.php";

use App\Helper\EnvHelper;

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic');
    header('HTTP/1.0 401 Unauthorized');
    die("Авторизация отменена");
} else {
    $envHelper = EnvHelper::getInstance();
    if ($_SERVER["PHP_AUTH_USER"] !== $envHelper->get("login") || $_SERVER["PHP_AUTH_PW"] !== $envHelper->get("password")) {
        die("Вы ввели неверный пароль");
    }
}