<?php

namespace Core;

class Request
{
    private string $method;
    private string $path;
    private array $bodyParams;
    private array $queryParams;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->queryParams = $_GET;
        $this->bodyParams = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public static function capture(): self
    {
        return new self();
    }

    // Retorna o metodo HTTP (GET, POST, etc.)
    public function getMethod(): string{
        return $this->method;
    }

    // Retorna o caminho da URL
    public function getPath(): string
    {
        return $this->path;
    }

    // Retorna os parâmetros de consulta (query params) da URL
    public function getBody(): array
    {
        return $this->bodyParams;
    }

    // Retorna os parâmetros do corpo da requisição (como o JSON)
    public function getQuery(): array
    {
        return $this->queryParams;
    }

    // Método para capturar a requisição atual
    public function hasHeader(string $key)
    {
        return isset(getallheaders()[$key]);
    }
}