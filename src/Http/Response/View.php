<?php

namespace App\Http\Response;

class View
{
    private string $path;
    private string $default = "home.php";

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Вывода ответа
     *
     * @return string
     */
    public function __invoke(): string
    {
        ob_start();
        include $this->getPath();

        return ob_get_clean();
    }

    /**
     * Получение пути к шаблону
     *
     * @return string
     */
    private function getPath(): string
    {
        $path = PUBLIC_PATH . "/view/" . $this->path;

        if (!file_exists($path)) {
            $path = PUBLIC_PATH . "/view/" . $this->default;
        }

        return $path;
    }
}