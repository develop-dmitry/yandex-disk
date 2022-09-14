<?php

namespace App\Ajax\Handlers;

interface HandlerInterface
{
    /**
     * Запускает обработчик
     *
     * @param array $params
     * @return array
     */
    public function run(array $params): array;
}