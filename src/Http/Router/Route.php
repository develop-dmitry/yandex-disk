<?php

namespace App\Http\Router;

use App\Http\Response\Response;

class Route
{
    private string $class;
    private string $handler;

    public function __construct($class, $handler)
    {
        $this->class = $class;
        $this->handler = $handler;
    }

    /**
     * Выполнение обработчика
     *
     * @return void
     */
    public function __invoke(): void
    {
        if (class_exists($this->class) && method_exists($this->class, $this->handler)) {
            $handler = $this->handler;

            $object = new $this->class();
            $response = $object->$handler();

            if ($response) {
                echo $response();
            }
        }
    }
}