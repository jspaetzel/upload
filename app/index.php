<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/vendor/autoload.php';
session_start();

// Instantiate the app
$settings = require __DIR__ . '/settings.php';
$app = new \Slim\App($settings);

$container = $app->getContainer();
$container['Db'] = function (\Slim\Container $container) {
    $cfg = $container->get('settings')['db'];
    return new DB($cfg['db_host'], $cfg['db_user'], $cfg['db_password'], $cfg['db_name']);
};

require __DIR__ . '/dependencies.php';
require __DIR__ . '/routes.php';

// Run app
$app->run();
