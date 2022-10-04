<?php

namespace App\Http\Router;

use App\Http\Request\Request;
use App\Http\Router\Exceptions\RouterException;

class Router
{
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Добавление обработчика POST запроса
     *
     * @param string $url
     * @param array $handler
     * @return void
     */
    public function post(string $url, array $handler): void
    {
        $this->addRoute("post", $url, $handler);
    }

    /**
     * Добавление обработчика GET запроса
     *
     * @param string $url
     * @param array $handler
     * @return void
     */
    public function get(string $url, array $handler): void
    {
        $this->addRoute("get", $url, $handler);
    }

    /**
     * Выполнение обработчика
     *
     * @throws RouterException
     */
    public function exec(): void
    {
        global $request;

        try {
            $route = $this->getRoute($request);
            $route();
        } catch (RouterException $exception) {
            if ($request->isGet()) {
                $this->set404($request);
            } else {
                throw $exception;
            }
        }
    }

    /**
     * Добавление обработчика
     *
     * @param string $type
     * @param string $url
     * @param array $handler
     * @return void
     */
    private function addRoute(string $type, string $url, array $handler): void
    {
        $this->routes[$url] = [
            $type => [
                "class" => $handler[0],
                "handler" => $handler[1]
            ]
        ];
    }

    /**
     * Получение обработчика по Request
     *
     * @param Request $request
     * @return Route
     * @throws RouterException
     */
    private function getRoute(Request $request): Route
    {
        $url = $request->getRequestUrl();
        $type = $request->getRequestType();

        if (!isset($this->routes[$url]) || !isset($this->routes[$url][$type])) {
            throw new RouterException("Обработчик url не найден");
        }

        return new Route(
            $this->routes[$url][$type]["class"],
            $this->routes[$url][$type]["handler"]
        );
    }

    /**
     * Установка 404 страницы
     *
     * @param Request $request
     * @return void
     */
    private function set404(Request $request): void
    {
        $request->setHeader("HTTP/1.0 404 Not Found");
        include PUBLIC_PATH . "/view/404.php";
    }
}