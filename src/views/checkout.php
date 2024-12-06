<?php
require_once __DIR__ . "/../utils/imports.php";

if (!isUserLogged()) {
    require_once __DIR__ . '/../views/login.php';
    exit();
}

// For development purposes

$name = "";
$address = "";
$zip = "";
$card = "";
$exp = "";
$cvv = "";

if (isset($_GET['example'])) {
    $name = "Home 1";
    $address = "1234 Main St, Apt 1, NY, USA";
    $zip = "23051";
    $card = "1234567890123456";
    $exp = "07/26";
    $cvv = "012";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <script src="/public/scripts/checkout.js" defer></script>
    <title>Checkout</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="w-3/4 flex flex-col items-center lg:w-2/3 mx-auto">
        <h2 class="text-xl border-b-2 w-1/2 pb-3 text-center font-bold mb-4 text-gray-600 mt-12">Checkout</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="w-3/4 max-w-sm mx-auto bg-red-700 mb-5 text-white p-3 rounded mt-4">
                <span class="mx-2">⚠️</span>
                <?php
                echo "  ";
                switch ($_GET['error']) {
                    case 1:
                        echo "All fields are required.";
                        break;
                    case 2:
                        echo "Invalid zip code.";
                        break;
                    case 3:
                        echo "Invalid card number.";
                        break;
                    case 4:
                        echo "Invalid expiration date.";
                        break;
                    case 5:
                        echo "Invalid CVV.";
                        break;
                    case 6:
                        echo "No products in the order.";
                        break;
                    default:
                        echo "Internal error.";
                        break;
                }
                ?>
            </div>
        <?php endif; ?>
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-x-12">
            <div>
                <form action="/order" method="POST" class="flex flex-col items-center">
                    <h3 class="w-full text-lg font-bold text-gray-600 text-left">📍 Shipping data</h3>
                    <input type="text" name="name" value="<?= $name ?>" placeholder="Name" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-3">
                    <input type="text" name="address" value="<?= $address ?>" placeholder="Address" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <input type="number" name="zip" value="<?= $zip ?>" placeholder="Zip code" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    <h3 class="w-full text-lg font-bold text-gray-600 text-left mt-4">💳 Payment data</h3>
                    <input type="text" name="card" value="<?= $card ?>" placeholder="Card number" class="w-72 h-10 border-2 border-gray-300 rounded-md px-2 mt-3">
                    <div class="flex gap-x-4 w-72">
                        <input type="text" name="exp" value="<?= $exp ?>" placeholder="Exp. (mm/yy)" class="w-1/2 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                        <input type="text" name="cvv" value="<?= $cvv ?>" placeholder="CVV" class="w-1/2 h-10 border-2 border-gray-300 rounded-md px-2 mt-5">
                    </div>
                    <!-- In cart Products (hidden) -->
                    <input type="hidden" name="products" value="" id="products-input">
                    <button type="submit" class="w-72 h-10 bg-black text-yellow-200 rounded-md mt-5">Place order</button>
                </form>
            </div>
            <div class="md:mt-0 mt-8 max-w-lg flex flex-col pt-4 pb-5 px-8 rounded-md  bg-white">
                <h3 class="font-semibold text-center text-gray-600 border-b-2 border-gray-200 pb-2 mb-2">Order Summary</h3>
                <div id="cart-summary">
                    <!-- Products here -->
                </div>
                <div class="mt-2 md:mt-auto border-t-2 border-gray-200 pt-2">
                    <p class="text-gray-600 text-lg font-bold">Total: $<span class="underline" id="total"></span></p>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . "/layout/footer.php"; ?>
</body>

</html>