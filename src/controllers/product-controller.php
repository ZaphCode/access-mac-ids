<?php
require_once __DIR__ . "/../utils/imports.php";

function redirectWithError($error, $isUpdating)
{
    header("Location: " . ($isUpdating ? "/public/product-form?update&id=" . $_GET["id"] : "/public/product-form") . "&error=$error");
    exit();
}

if (!isUserLogged()) {
    header("Location: /public");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"] ?? null;
    $price = $_POST["price"] ?? null;
    $description = $_POST["description"] ?? null;
    $image_src = $_POST["image_src"] ?? null;
    $category = $_POST["category"] ?? null;
    $rating = $_POST["rating"] ?? null;
    $stock = $_POST["stock"] ?? null;

    $isUpdating = isset($_GET["update"]) && isset($_GET["id"]);

    // Validar campos vacíos o con solo espacios en blanco
    if (
        empty(trim($name)) || empty(trim($price)) || empty(trim($description)) ||
        empty(trim($image_src)) || empty(trim($category)) || empty(trim($stock))
    ) {
        redirectWithError(1, $isUpdating);
    }

    if (!is_numeric($price) || $price <= 0 || !is_numeric($stock) || $stock < 0) {
        redirectWithError(2, $isUpdating);
    }

    if (!is_numeric($rating) || $rating < 0 || $rating > 5) {
        redirectWithError(3, $isUpdating);
        exit();
    }


    try {
        $pdo = getPDO();
        $productStorage = new ProductStorage($pdo);

        if (isset($_GET["update"]) && isset($_GET["id"])) {
            // Actualización de producto
            $id = $_GET["id"];
            $product = $productStorage->getProductById($id);

            if (!$product) {
                redirectWithError(4, $isUpdating);
            }

            $updated = $productStorage->updateProduct($id, $name, $price, $description, $image_src, $category, $rating, $stock);

            if ($updated) {
                header("Location: /public/admin?success=1");
                exit();
            } else {
                redirectWithError(5, $isUpdating);
            }
        } else {
            // Creación de producto
            $id = $productStorage->createProduct($name, $price, $description, $image_src, $category, $rating, $stock);

            if ($id) {
                header("Location: /public/admin?success=2");
                exit();
            } else {
                redirectWithError(6, $isUpdating);
            }
        }
    } catch (\Throwable $th) {
        redirectWithError(7, $isUpdating);
    }
} else {
    header("Location: /public");
    exit();
}
