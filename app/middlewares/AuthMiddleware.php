<?php

namespace App\middlewares;

use Core\Middleware;
use Core\Request;

class AuthMiddleware extends Middleware
{
    public function handle(Request $request)
    {
        // Exemplo: verificar se o usuário está autenticado
        if ($request->hasHeader('Authorization')) {
            die('Unauthorized: Missing Authorization Header');
        }
    }
}