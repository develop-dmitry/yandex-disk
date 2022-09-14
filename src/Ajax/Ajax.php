<?php

namespace App\Ajax;

class Ajax
{
    public static function run(array $request): string
    {
        if ($handler = AjaxHandlerContainer::getInstance()->get($request["action"])) {
            $result = $handler->run($request);
        } else {
            $result["result"] = false;
            $result["message"] = "При выполнении запроса произошла ошибка";
        }
        return json_encode($result);
    }
}