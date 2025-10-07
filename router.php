<?php

namespace App;

use App\Helpers\AppLogger;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->base("GET", $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->base("GET", $path, $handler);
    }

    public function base(string $method, string $path, callable $handler): void
    {
        AppLogger::logger()->info("Responding to [$method] $path. Woohoo!!");
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        $handler = $this->routes[$method][$uri] ?? null;

        if ($handler) {
            echo $handler();
        } else {
            http_response_code(404);
            include __DIR__ . "/view/error/404.php";
        }
    }
}
