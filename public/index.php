<?php
define('URL', '/public');

$request = $_SERVER['REQUEST_URI'];
$request = strtok(str_replace(URL, '', $request), '?');

switch ($request) {
    case '/login':
        require_once __DIR__ . '/../src/views/login.php';
        break;
    case '/':
        require_once __DIR__ . '/../src/views/index.php';
        break;
    default:
        http_response_code(404);
        echo "404 - Ruta no encontrada";
        break;
}
