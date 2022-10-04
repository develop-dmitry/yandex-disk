<?php

namespace App\Http\Response;

class Response
{
    private bool $success;
    private string $message;
    private array $response;

    public function __construct(bool $success = false, string $message = "", array $response = [])
    {
        $this->success = $success;
        $this->response = $response;
        $this->message = $message;
    }

    /**
     * Устанавливает успешность ответа
     *
     * @param bool $success
     * @return void
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    /**
     * Устанавливает сообщение ответа
     *
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Устанавливает результат выполнения запроса
     *
     * @param array $response
     * @return void
     */
    public function setResponse(array $response): void
    {
        $this->response = [];

        foreach ($response as $key => $item) {
            $this->addResponse($key, $item);
        }
    }

    /**
     * Добавляет значение в массив ответа
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function addResponse(string $name, mixed $value): void
    {
        $this->response[$name] = $value;
    }

    /**
     * Вывод ответа
     *
     * @return string
     */
    public function __invoke(): string
    {
        return json_encode([
            "success" => $this->success,
            "message" => $this->message,
            "response" => $this->response
        ]);
    }
}