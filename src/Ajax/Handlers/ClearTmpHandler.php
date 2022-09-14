<?php

namespace App\Ajax\Handlers;

use App\Helper\FileHelper;

class ClearTmpHandler implements HandlerInterface
{
    public function run(array $params): array
    {
        FileHelper::clearTmp();
        return ["result" => true];
    }
}