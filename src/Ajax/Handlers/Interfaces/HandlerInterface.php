<?php

namespace App\Ajax\Handlers\Interfaces;

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