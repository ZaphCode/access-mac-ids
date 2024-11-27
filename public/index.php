<?php
define('URL', '/public');

$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?');

switch ($request) {
    case URL . '/':
        require_once __DIR__ . '/../src/views/index.php';
        break;

    default:
        http_response_code(404);
        break;
}

// switch($request){
//     case URL.'/':
//         require_once __DIR__.'/../src/views/public/welcome.php';
//         break;
//     case URL.'/carreras':
//         require_once __DIR__.'/../src/views/public/careers/details.php';
//         break;
//     case URL.'/careers':
//         require_once __DIR__.'/../src/views/admin/careers/index.php';
//         break;
//     case URL.'/careers/form':
//         require_once __DIR__.'/../src/views/admin/careers/form.php';
//         break;
//     case URL.'/login':
//         require_once __DIR__.'/login.php';
//         break;
//     case URL.'/logout':
//         require_once __DIR__.'/../src/controllers/logoutController.php';
//         break;
//     default:
//         http_response_code(404);
//         //Hacer una vista de 404
//         break;

// }
