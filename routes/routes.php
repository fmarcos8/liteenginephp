<?php

use Core\Router;

$router = new Router();

$router->get('/home', [App\controllers\HomeController::class, 'index']);


return $router;