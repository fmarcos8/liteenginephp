<?php

namespace Core;

use App\helpers\Log;

class Kernel
{
    protected array $middlewares = [];
    protected Router $router;

    public function __construct()
    {
        $this->router = require_once __DIR__ . '/../routes/routes.php';
    }

    public function addMiddleware(string $name, callable $middleware): void
    {
        $this->middlewares[$name] = $middleware;
    }

    public function handle(Request $request): mixed
    {
        foreach ($this->middlewares as $middleware) {
            $middlewareInstance = new $middleware();
            $middlewareInstance->handle($this);
        }

        return $this->router->dispatch($request);
    }
}