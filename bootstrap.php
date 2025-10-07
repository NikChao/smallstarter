<?php

function view($name, $data = [])
{
    extract($data);
    ob_start();

    $path = __DIR__ . "/view/{$name}";

    if (file_exists("{$path}.php")) {
        include "{$path}.php";
    } elseif (file_exists("{$path}.html")) {
        include "{$path}.html";
    }

    $content = ob_get_clean();
    include __DIR__ . "/view/layout.php";
}

function api($name, $data = [])
{
    header('Content-Type: application/json');
    include __DIR__ . "/api/{$name}.php";
}
