<?php
require_once __DIR__ . "/../utils/imports.php";

if (!isUserLogged()) {
    require_once __DIR__ . '/../views/login.php';
    exit();
}

$userStorage = new UserStorage(getPDO());
$user = $userStorage->getUserByEmail(getAuthUser());

$orderStorage = new OrderStorage(getPDO());
$orders = $orderStorage->getFromUserId($user["id"]);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <script src="/public/scripts/favorites.js" defer></script>
    <title>Home</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="w-3/4 lg:w-2/3 xl:w-1/2 mx-auto">
        <div class="bg-white px-8 py-4 items-center gap-x-4 flex mx-auto rounded-md mt-12 w-full sm:w-4/5  lg:w-2/3">
            <div class="flex">
                <svg class="w-14 h-14 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Zm0 0a8.949 8.949 0 0 0 4.951-1.488A3.987 3.987 0 0 0 13 16h-2a3.987 3.987 0 0 0-3.951 3.512A8.948 8.948 0 0 0 12 21Zm3-11a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </div>
            <div class="flex flex-col">
                <h3 class="font-bold text-lg">
                    Hello <?= $user["username"] ?> 👋!
                </h3>
                <span class="text-gray-500 italic -mt-1"><?= $user["email"] ?></p>
            </div>
            <div class="ml-auto">
                <a class="text-red-900 underline" href="/logout">Logout</a>
            </div>
        </div>
        <h2 class="flex justify-center items-center font-bold mt-6 mb-5 lg:mt-10 text-lg text-center text-gray-600">
            <svg class="w-6 h-6 text-red-500 mx-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path d="m12.75 20.66 6.184-7.098c2.677-2.884 2.559-6.506.754-8.705-.898-1.095-2.206-1.816-3.72-1.855-1.293-.034-2.652.43-3.963 1.442-1.315-1.012-2.678-1.476-3.973-1.442-1.515.04-2.825.76-3.724 1.855-1.806 2.201-1.915 5.823.772 8.706l6.183 7.097c.19.216.46.34.743.34a.985.985 0 0 0 .743-.34Z" />
            </svg>
            Your Favorite Products
        </h2>
        <div id="favorite-container" class="grid w-full grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-x-4 gap-y-8">
            <!-- Products will be dynamically added here -->
        </div>
        <h2 class="flex pt-10 border-t-2 border-gray-300 w-2/3 mx-auto justify-center items-center font-bold mt-6 mb-5 lg:mt-10 text-lg text-center text-gray-600">
            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M5.024 3.783A1 1 0 0 1 6 3h12a1 1 0 0 1 .976.783L20.802 12h-4.244a1.99 1.99 0 0 0-1.824 1.205 2.978 2.978 0 0 1-5.468 0A1.991 1.991 0 0 0 7.442 12H3.198l1.826-8.217ZM3 14v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5h-4.43a4.978 4.978 0 0 1-9.14 0H3Z" clip-rule="evenodd" />
            </svg>
            Your Orders
        </h2>
        <div>
            <?php if (empty($orders)) : ?>
                <p class="text-center text-gray-500 mt-5">You don't have any orders yet.</p>
            <?php else : ?>
                <div class="grid grid-cols-1 gap-4">
                    <?php foreach ($orders as $order) : ?>
                        <div class="bg-white p-4 rounded-md shadow-md">
                            <h3 class="font-bold text-lg text-gray-600">Order #<?= $order["id"] ?></h3>
                            <p class="text-gray-500">Total: $<?= $order["total"] ?></p>
                            <p class="text-gray-500">Payment Method: <?= $order["payment_method"] ?></p>
                            <p class="text-gray-500">Shipping Address: <?= $order["shipping_address"] ?></p>
                            <p class="text-gray-500">Status: <?= $order["status"] ?></p>
                            <div class="flex gap-2 mt-4">
                                <button class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-md text-white">Cancel Order</button>
                                <button class="bg-blue-500 hover:bg-blue-600 px-3 py-1 rounded-md text-white">Track Order</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

</body>

</html>