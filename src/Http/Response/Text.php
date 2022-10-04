<?php

namespace App\Http\Response;

class Text
{
    private string $text;

    public function __construct($text)
    {
        $this->setText($text);
    }

    /**
     * Устанавливает текст ответа
     *
     * @param $text
     * @return void
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * Вывод ответа
     *
     * @return string
     */
    public function __invoke(): string
    {
        return $this->text;
    }
}