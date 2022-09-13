<?php

namespace App\Router\Ajax;

use App\Helper\FileHelper;

class ClearTmpAjaxHandler implements AjaxHandlerInterface
{
    public function run(array $params): array
    {
        FileHelper::clearTmp();
        return ["result" => true];
    }
}