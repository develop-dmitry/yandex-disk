<?php

namespace App\Helper;

use Symfony\Component\Dotenv\Dotenv;

class EnvHelper
{
    private static EnvHelper $helper;
    private Dotenv $dotenv;

    private function __construct()
    {
        $envPath = dirname($_SERVER["DOCUMENT_ROOT"], 1) . "/.env";
        $this->dotenv = new Dotenv();
        $this->dotenv->load($envPath);
    }

    public static function getInstance(): EnvHelper
    {
        if (!isset(self::$helper)) {
            self::$helper = new EnvHelper();
        }
        return self::$helper;
    }

    public function get(string $name): string|false
    {
        if (isset($_ENV[$name])) {
            return $_ENV[$name];
        }
        return false;
    }
}