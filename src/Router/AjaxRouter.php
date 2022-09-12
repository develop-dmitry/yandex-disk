<?php

namespace App\Router;

use App\Router\Ajax\AjaxHandlerContainer;

class AjaxRouter
{
    public static function run(array $request): string
    {
        $ajaxContainer = AjaxHandlerContainer::getInstance();
        if ($handler = $ajaxContainer->get($request["action"])) {
            $result = $handler->run($request);
        } else {
            $result["result"] = false;
            $result["message"] = "При выполнении запроса произошла ошибка";
        }
        return json_encode($result);
    }
}