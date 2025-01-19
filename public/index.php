<?php

require __DIR__ . '/../error_handler.php';
require __DIR__ . '/../vendor/autoload.php';

Core\Cors::handle();

$kernel = new Core\Kernel();

$response = $kernel->handle(\Core\Request::capture());
$response->send();