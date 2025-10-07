<?php

require __DIR__ . '/../bootstrap.php';

$folders = ['helpers', 'db'];
foreach ($folders as $folder) {
    foreach (glob(__DIR__ . "/../$folder/*.php") as $file) {
        require $file;
    }
}

require __DIR__ . '/../router.php';
require __DIR__ . '/../vendor/autoload.php';

use App\Router;

$router = new Router();

// pages
$router->get('/', fn () => view('home'));
$router->get('/page', fn () => view('page'));
$router->get('/time', fn () => view('time'));

// api routes
$router->get('/api/random', fn () => api('random'));
$router->get('/api/time', fn () => api('time'));

$router->dispatch();
