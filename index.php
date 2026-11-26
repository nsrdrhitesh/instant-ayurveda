<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (is_file($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';
$app->useEnvironmentPath(dirname(__DIR__));
$app->handleRequest(Request::capture());
