<?php
return [
    "db" => [
        'host' => 'localhost',
        'name' => 'lite_engine_db',
        'user' => 'root',
        'pass' => 'pipoca',
        'options' => [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    ]
];