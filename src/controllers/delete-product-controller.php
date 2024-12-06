<?php
require_once __DIR__ . "/../utils/imports.php";

if (!isUserLogged()) {
    header("Location: /public/");
    exit();
}

$pdo = getPDO();

$userStorage = new UserStorage($pdo);
$user = $userStorage->getUserByEmail(getAuthUser());

if ($user["role"] !== "admin") {
    header("Location: /public");
    exit();
}

if (isset($_GET["id"])) {
    $productStorage = new ProductStorage($pdo);
    $product = $productStorage->getProductById($_GET["id"]);

    if (!$product) {
        header("Location: /public/admin");
        exit();
    }

    $productStorage->deleteProduct($_GET["id"]);
    header("Location: /public/admin?success=3");
    exit();
}
