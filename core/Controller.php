<?php

namespace Core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class Controller
{
    protected Environment $twig;
    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../app/views');
        $this->twig = new Environment($loader, [
            'cache' => __DIR__ . '/../storage/cache', // Altere para 'null' se não quiser cache
            'debug' => true,                         // Ative para depuração
        ]);
        $this->twig->addExtension(new DebugExtension());
    }

    /**
     * @param string $view Nome do template (ex.: 'home.html.twig')
     * @param array $data Dados para passar ao template
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function render(string $view, array $data = []): string
    {
        return $this->twig->render($view, $data);
    }

    /**
     * Retorna uma resposta JSON
     *
     * @param mixed $data Dados a serem retornados como JSON
     * @param int $statusCode Código de status HTTP
     * @return void
     */
    protected function json($data, $statusCode = 200): void
    {
        header('Content-type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
    }
}