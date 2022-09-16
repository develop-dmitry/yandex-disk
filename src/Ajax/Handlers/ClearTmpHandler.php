<?php

namespace App\Ajax\Handlers;

use App\Ajax\Handlers\Interfaces\HandlerInterface;
use App\Helpers\FileHelper;

class ClearTmpHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        FileHelper::clearTmp();
        return ["result" => true];
    }
}