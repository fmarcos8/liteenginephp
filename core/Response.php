<?php

namespace Core;

class Response
{
    public function __construct(
        protected string $content,
        protected int $statusCode = 200
    ) {}

    public function send(): void
    {
        http_response_code($this->statusCode);
        echo $this->content;
    }
}