<?php
define('URL', '/public');

$request = $_SERVER['REQUEST_URI'];
$request = strtok(str_replace(URL, '', $request), '?');

switch ($request) {
    case '/account':
        require_once __DIR__ . '/../src/views/account.php';
        break;
    case '/admin':
        require_once __DIR__ . '/../src/views/admin-panel.php';
        break;
    case '/product-form':
        require_once __DIR__ . '/../src/views/product-form.php';
        break;
    case '/product':
        require_once __DIR__ . '/../src/views/product.php';
        break;
    case '/cart':
        require_once __DIR__ . '/../src/views/cart.php';
        break;
    case '/checkout':
        require_once __DIR__ . '/../src/views/checkout.php';
        break;
    case '/order-confirmation':
        require_once __DIR__ . '/../src/views/order-confirmation.php';
        break;
    case '/signin':
        require_once __DIR__ . '/../src/controllers/signin-controller.php';
        break;
    case '/signup':
        require_once __DIR__ . '/../src/controllers/signup-controller.php';
        break;
    case '/order':
        require_once __DIR__ . '/../src/controllers/order-controller.php';
        break;
    case '/product':
        require_once __DIR__ . '/../src/controllers/product-controller.php';
        break;
    case '/logout':
        require_once __DIR__ . '/../src/controllers/logout-controller.php';
        break;
    case '/product-delete':
        require_once __DIR__ . '/../src/controllers/delete-product-controller.php';
        break;
    case '/':
        require_once __DIR__ . '/../src/views/index.php';
        break;
    default:
        http_response_code(404);
        require_once __DIR__ . '/../src/views/not-found.php';
        break;
}
