<?php
require_once __DIR__ . "/../utils/imports.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isUserLogged()) {
        header("Location: /public/login");
        exit();
    }
    try {
        $userStorage = new UserStorage(getPDO());
        $user = $userStorage->getUserByEmail(getAuthUser());

        $name = trim($_POST['name'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $zip = trim($_POST['zip'] ?? '');
        $card = trim($_POST['card'] ?? '');
        $exp = trim($_POST['exp'] ?? '');
        $cvv = trim($_POST['cvv'] ?? '');
        $products = json_decode($_POST['products'] ?? '[]', true);

        if (!$name || !$address || !$zip || !$card || !$exp || !$cvv || empty($products)) {
            header("Location: /public/checkout?error=1");
            exit();
        }

        if (!preg_match('/^\d{5}$/', $zip)) {
            header("Location: /public/checkout?error=2");
            exit();
        }

        if (!preg_match('/^\d{16}$/', $card)) {
            header("Location: /public/checkout?error=3");
            exit();
        }

        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $exp)) {
            header("Location: /public/checkout?error=4");
            exit();
        }

        if (!preg_match('/^\d{3,4}$/', $cvv)) {
            header("Location: /public/checkout?error=5");
            exit();
        }

        if (!is_array($products) || count($products) === 0) {
            header("Location: /public/checkout?error=6");
            exit();
        }

        $total = array_reduce($products, function ($carry, $product) {
            return $carry + ($product['price'] * $product['quantity']);
        }, 0);

        $card_last_digits = substr($card, -4);
        $full_address = "\"$name\" $address; $zip";

        $orderStorage = new OrderStorage(getPDO());
        $orderData = [
            'user_id' => $user['id'],
            'total' => $total,
            'products' => $products,
            'payment_method' => $card_last_digits,
            'shipping_address' => $full_address,
        ];

        $order = $orderStorage->create($orderData);

        header("Location: /public/order-confirmation?id=" . $order['id']);
        exit();
    } catch (\Throwable $th) {
        header("Location: /public/checkout?error=10");
        exit();
    }
}
