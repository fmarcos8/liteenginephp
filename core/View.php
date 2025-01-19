<?php

namespace Core;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class View
{
    private Environment $twig;

    public function __construct(string $viewDir, string $cacheDir = null)
    {
        $loader = new FilesystemLoader($viewDir);
        $this->twig = new Environment($loader, [
            'cache' => $cacheDir,
            'debug' => true,
        ]);
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view, $params);
    }
}