<?php
require_once './vendor/autoload.php';

use Core\Migration;

$migrationsPath = __DIR__ . '/migrations';
$migrations = scandir($migrationsPath);

foreach ($migrations as $migration) {
    if ($migration === '.' or $migration === '..') continue;

    require_once $migrationsPath . '/' . $migration;

    $fileName = preg_replace('/[0-9]+/', '', pathinfo($migration, PATHINFO_FILENAME));
    $className = Migration::getMigrationClassName($fileName);
    $migrationObj = new $className();

    echo "Applying migration: $migration\n";
    $migrationObj->up();
}