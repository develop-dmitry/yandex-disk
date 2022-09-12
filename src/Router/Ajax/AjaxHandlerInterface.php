<?php

namespace App\Router\Ajax;

interface AjaxHandlerInterface
{
    public function run(array $params): array;
}