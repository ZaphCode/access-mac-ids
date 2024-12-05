<?php
require_once __DIR__ . "/../utils/imports.php";
$productStorage = new ProductStorage(getPDO());
$products = $productStorage->getAllProducts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <title>Home</title>
</head>

<body class="bg-gray-100">
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="w-4/5 md:w-4/6 xl:w-3/5 px-6 mx-auto">
        <div class="mt-4 h-64 xl:h-80 flex gap-x-3">
            <div class="w-2/3">
                <img class="w-full h-full object-cover" src="/public/assets/img-1.jpg" alt="macbook">
            </div>
            <div class="w-1/3 flex flex-col gap-3 overflow-hidden">
                <img class="w-full h-2/5 object-cover " src="/public/assets/img-3.jpg" alt="apple watch">
                <img class="w-full h-3/5 h- object-cover " src="/public/assets/img-2.jpg" alt="gadgets">
            </div>
        </div>

        <div class="w-full text-xs lg:text-sm flex py-5 justify-center gap-x-14 px-5 bg-white rounded-md mt-4">
            <div class="flex items-center">
                <img class="h-6 m" src="/public/assets/iphone.svg" alt="iphone">
                <p>iPhone</p>
            </div>
            <div class="flex items-center gap-x-2">
                <img class="h-6 " src="/public/assets/macbook.svg" alt="iphone">
                <p>MacBook</p>
            </div>
            <div class="flex items-center gap-x-3">
                <img class="h-6 " src="/public/assets/ipad.svg" alt="iphone">
                <p>iPad</p>
            </div>
            <div class="flex items-center">
                <img class="h-6 " src="/public/assets/watch.svg" alt="iphone">
                <p>Apple Watch</p>
            </div>
        </div>
        <div class="flex mt-6 text-gray-500 justify-between">
            <h2 class="font-bold text-lg">Newest Products</h2>
            <div class="flex gap-x-2 ">
                <p class="border-r-2 border-gray-500 pr-3">All</p>
                <!-- Move arrows -->
                <button id="scroll-left">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12l4-4m-4 4 4 4" />
                    </svg>
                </button>
                <button id="scroll-right">
                    <svg class="w-6 h-6 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="relative overflow-hidden mt-3">
            <div id="product-container" class="flex gap-5 overflow-x-auto scroll-smooth scrollbar-hide">
                <!-- Product cards -->
                <?php foreach ($products as $product) : ?>
                    <div class="bg-white h-72 w-48 flex-shrink-0">
                        <div class="h-4/6 flex relative justify-center items-center">
                            <!-- Favorite Button -->
                            <button class="absolute top-2 left-2 favorite-button" data-product='<?= json_encode($product) ?>'>
                                <svg class="w-6 h-6 text-gray-400 favorite-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z" />
                                </svg>
                            </button>
                            <!-- Add to Cart Button -->
                            <button class="absolute top-2 right-2 cart-button" data-product='<?= json_encode($product) ?>'>
                                <svg class="w-6 h-6 text-gray-400 cart-icon" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4" />
                                </svg>
                            </button>
                            <img class="w-5/6 max-h-32 object-scale-down" src="<?= $product["image_src"] ?>" alt="<?= $product["name"] ?>">
                        </div>
                        <div class="flex pb-6 flex-col items-center justify-center h-1/6">
                            <p class="text-sm font-bold"><?= $product["name"] ?></p>
                            <p class="text-sm text-gray-500">$<?= $product["price"] ?></p>
                        </div>
                        <button class="w-full h-1/6 bg-black text-yellow-200">Shop now</button>
                    </div>
                <?php endforeach; ?>

                <!-- Add more cards dynamically -->
            </div>
        </div>

    </main>
    <footer class="w-full mt-20 text-center bg-white">
        hola
    </footer>
    <script>
        const container = document.getElementById('product-container');
        const scrollLeft = document.getElementById('scroll-left');
        const scrollRight = document.getElementById('scroll-right');

        const scrollAmount = 212;

        scrollLeft.addEventListener('click', () => {
            container.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });

        scrollRight.addEventListener('click', () => {
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });
    </script>
</body>

</html>