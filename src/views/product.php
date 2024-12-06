<?php
require_once __DIR__ . "/../utils/imports.php";
$productStorage = new ProductStorage(getPDO());

if (isset($_GET['id'])) {
    $product = $productStorage->getProductById($_GET['id']);
    if (!$product) {
        header("Location: /product-not-found");
        exit();
    }
} else {
    header("Location: /");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <title><?= htmlspecialchars($product['name']) ?> - Product Details</title>
</head>

<body class="">
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="w-4/5 md:w-4/6 xl:w-3/5 lg:mb-10 px-6 mx-auto mt-12">
        <div class="grid bg-white mb-10 p-8 rounded-md grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="flex justify-center p-5 items-center">
                <img class="w-full max-w-md h-auto object-contain" src="<?= htmlspecialchars($product['image_src']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            </div>
            <div class="flex flex-col justify-center">
                <h1 class="text-3xl font-bold text-black mb-4"><?= htmlspecialchars($product['name']) ?></h1>
                <p class="text-lg text-gray-700 mb-6"><?= htmlspecialchars($product['description']) ?></p>
                <div class="flex items-center mb-4">
                    <p class="text-xl font-semibold text-gray-500 mr-4">$<?= number_format($product['price'], 2) ?></p>
                    <div class="flex items-center text-yellow-300">
                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <svg class="w-5 mr-1 h-5 <?= $i < $product['rating'] ? 'fill-current' : 'text-gray-300' ?>" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 .587l3.668 7.431 8.156 1.185-5.906 5.758 1.392 8.115-7.547-3.969-7.547 3.969 1.392-8.115-5.906-5.758 8.156-1.185L12 .587z" />
                            </svg>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="flex justify-start gap-x-4 items-center">

                    <button id="buy-btn" data-product='<?= json_encode($product) ?>' class="bg-black text-yellow-200 px-6 py-2 rounded-lg transition duration-300" )>
                        Buy Now
                    </button>
                    <button class=" favorite-button" data-product='<?= json_encode($product) ?>'>
                        <svg class="w-6 h-6 text-gray-400 favorite-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                        </svg>
                    </button>
                    <!-- Add to Cart Button -->
                    <button class="cart-button" data-product='<?= json_encode($product) ?>'>
                        <svg class="w-6 h-6 text-gray-400 cart-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6">
                    <p class="text-lg font-semibold <?= $product['stock'] > 0 ? 'text-gray-300 underline' : 'text-red-600' ?>">
                        <?= $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' ?>
                    </p>
                </div>
            </div>
        </div>

    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const buyBtn = document.getElementById("buy-btn");

            buyBtn.addEventListener("click", function() {
                const product = JSON.parse(buyBtn.dataset.product);

                if (!GlobalState.isInCart(product.id)) {
                    GlobalState.addToCart(product);
                }

                window.location.href = "/public/checkout";
            });

        });
    </script>

    <?php include __DIR__ . "/layout/footer.php"; ?>
</body>


</html>