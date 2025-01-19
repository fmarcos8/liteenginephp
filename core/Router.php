<?php

namespace Core;

use App\helpers\Log;

class Router {
    private array $routes = [];

    public function add(string $route, array $controllerMethod, string $httpMethod = "GET", $name = null, array $middlewares = []): void
    {
        $this->routes[] = [
            'route' => $route,
            'controllerMethod' => $controllerMethod,
            'httpMethod' => strtoupper($httpMethod),
            'name' => $name,
            'middlewares' => $middlewares
        ];
    }

    public function get(string $route, array $controllerMethod, $name = null, $middlewares = []): void
    {
        $this->add($route, $controllerMethod, "GET", $name, $middlewares);
    }

    public function post(string $route, array $controllerMethod, $name = null, $middlewares = []): void
    {
        $this->add($route, $controllerMethod, "POST", $name, $middlewares);
    }

    public function put(string $route, array $controllerMethod, $name = null, $middlewares = []): void
    {
        $this->add($route, $controllerMethod, "PUT", $name, $middlewares);
    }

    public function delete(string $route, array $controllerMethod, $name = null, $middlewares = []): void
    {
        $this->add($route, $controllerMethod, "DELETE", $name, $middlewares);
    }

    public function dispatch(Request $request): Response
    {
        $url = $request->getPath();
        $requestMethod = $request->getMethod();

        foreach ($this->routes as $route) {
            $pattern = $this->getPattern($route['route']);

            if (preg_match($pattern, $url, $matches) && $route['httpMethod'] == $requestMethod) {
                array_shift($matches);
                $controllerMethod = $route['controllerMethod'];
                $controller = new $controllerMethod[0]();
                $method = $controllerMethod[1];

                // Executa middlewares da rota
                foreach ($route['middlewares'] as $middleware) {
                    $middlewareInstance = new $middleware();
                    $middlewareInstance->handler($request);
                }

                // Junta parâmetros do corpo e da URL
                $bodyParams = $request->getBody();
                $queryParams = $request->getQuery();
                $params = array_merge($bodyParams, $queryParams, $matches);

                //Invoca o controlador
                $responseContent = !empty($params)
                    ? $controller->$method($params)
                    : $controller->$method();

                return new Response($responseContent);
            }
        }

        return new Response('404 Not Found', 404);
    }

    private function getPattern(string $route): string
    {
        $pattern = preg_replace_callback('/\{([a-zA-Z0-9_]+)\}/', function ($matches) {
            return '([a-zA-Z0-9_\-]+)';
        }, $route);

        return "#^$pattern$#";
    }
}