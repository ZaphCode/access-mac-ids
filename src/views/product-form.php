<?php
require_once __DIR__ . "/../utils/imports.php";

if (!isUserLogged()) {
    require_once __DIR__ . '/../views/login.php';
    exit();
}

$pdo = getPDO();

$userStorage = new UserStorage($pdo);
$productStorage = new ProductStorage($pdo);

$user = $userStorage->getUserByEmail(getAuthUser());

if ($user["role"] !== "admin") {
    header("Location: /public");
    exit();
}

$product_name = "";
$product_price = "";
$product_description = "";
$product_image = "";
$category = "";
$product_stock = "";
$product_rating = "";
$product_id = "";

$isUpdate = isset($_GET["update"]);

if ($isUpdate) {

    if (!isset($_GET["id"])) {
        header("Location: /public");
        exit();
    }

    $product_id = $_GET["id"];
    $product = $productStorage->getProductById($product_id);

    if (!$product) {
        header("Location: /public");
        exit();
    }

    $product_name = $product["name"];
    $product_price = $product["price"];
    $product_description = $product["description"];
    $product_image = $product["image_src"];
    $category = $product["category"];
    $product_stock = $product["stock"];
    $product_rating = $product["rating"];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <title>Create Product</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="flex flex-col items-center mt-14">
        <div>
            <h3 class="text-xl font-semibold text-gray-600">
                <?php if ($isUpdate) : ?>
                    🖥️ Update Product
                <?php else : ?>
                    🖥️ New Product
                <?php endif; ?>
            </h3>
        </div>
        <div class="h-52 w-2/3 max-w-xl border-gray-300 mt-4 border-t-2 min-w-48">
            <?php if (isset($_GET["error"])) : ?>
                <div id="error-div" class="bg-red-700 w-1/2 text-sm py-2 mx-auto mt-4 text-center rounded-sm text-white">
                    <?php
                    switch ($_GET['error']) {
                        case 1:
                            echo "⚠️ All fields are required.";
                            break;
                        case 2:
                            echo "⚠️ Price and stock must be positive numbers.";
                            break;
                        case 3:
                            echo "⚠️ Rating must be between 0 and 5.";
                            break;
                        case 4:
                            echo "⚠️ Product not found.";
                            break;
                        case 5:
                            echo "⚠️ Could not update the product. Please try again.";
                            break;
                        case 6:
                            echo "⚠️ Could not create the product. Please try again.";
                            break;
                        case 7:
                            echo "⚠️ An unexpected error occurred. Contact support.";
                            break;
                        default:
                            echo "⚠️ Something went wrong. Please try again.";
                            break;
                    }
                    ?>
                </div>
            <?php endif; ?>
            <div class="mt-1">
                <form action="<?= !$isUpdate ? "/product" : "/product?id=$product_id&update" ?>" method="POST" class="flex flex-col items-center">
                    <input type="text" value="<?= $product_name ?>" name="name" placeholder="Name" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="text" value="<?= $product_description ?>" name="description" placeholder="Description" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="number" value="<?= $product_price ?>" name="price" placeholder="price" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="number" value="<?= $product_rating ?>" name="rating" placeholder="Rating" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="number" value="<?= $product_stock ?>" name="stock" placeholder="Stock" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="url" value="<?= $product_image ?>" name="image_src" placeholder="Image ur" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <select name="category" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                        <option value="laptops" <?= $category === "laptops" ? "selected" : "" ?>>Laptops</option>
                        <option value="wearables" <?= $category === "wearables" ? "selected" : "" ?>>Wearables</option>
                        <option value="smartphones" <?= $category === "smartphones" ? "selected" : "" ?>>Smartphones</option>
                        <option value="tablets" <?= $category === "tablets" ? "selected" : "" ?>>Tablets</option>
                        <option value="desktops" <?= $category === "desktops" ? "selected" : "" ?>>Desktops</option>
                        <option value="accessories" <?= $category === "accessories" ? "selected" : "" ?>>Accessories</option>
                        <option value="other" <?= $category === "other" ? "selected" : "" ?>>Other</option>
                    </select>
                    <button type="submit" class="w-72 h-10 bg-black text-yellow-200 rounded-md mt-5">Submit</button>
                </form>
            </div>
        </div>
    </main>
    <?php include __DIR__ . "/layout/footer.php"; ?>
</body>

</html>