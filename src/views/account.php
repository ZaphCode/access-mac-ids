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
    <script src="/public/scripts/accounts.js" defer></script>
    <title>Account</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="w-3/4 lg:w-2/3 xl:w-1/2 mx-auto mb-12">
        <div class="bg-white px-8 py-4 items-center gap-x-4 flex mx-auto rounded-md mt-12 w-full md:w-9/12">
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
            <div class="ml-auto flex flex-col items-end">
                <button id="logout-btn" class="text-red-900 underline">Logout</button>
                <?php if ($user["role"] === "admin") : ?>
                    <a class="text-blue-900 underline" href="/admin">Admin Panel</a>
                <?php endif; ?>
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
        <h2 class="flex pt-6 border-t-2 border-gray-300 w-2/3 mx-auto justify-center items-center font-bold mt-6 mb-5 lg:mt-7 text-lg text-center text-gray-600">
            <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M5.024 3.783A1 1 0 0 1 6 3h12a1 1 0 0 1 .976.783L20.802 12h-4.244a1.99 1.99 0 0 0-1.824 1.205 2.978 2.978 0 0 1-5.468 0A1.991 1.991 0 0 0 7.442 12H3.198l1.826-8.217ZM3 14v5a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-5h-4.43a4.978 4.978 0 0 1-9.14 0H3Z" clip-rule="evenodd" />
            </svg>
            Your Orders
        </h2>
        <div>
            <?php if (empty($orders)) : ?>
                <p class="text-center text-gray-500 mt-5">You don't have any orders yet.</p>
            <?php else : ?>
                <div class="flex mx-auto flex-col items-center w-full md:w-2/3 lg:w-4/5 gap-y-3">
                    <?php foreach ($orders as $order) : ?>
                        <div class="bg-white w-full flex p-4 rounded-md ">
                            <div class="w-3/4">
                                <div class="flex gap-x-3 items-center">
                                    <h3 class="font-bold text-lg text-gray-800">Order #<?= $order["id"] ?> </h3>
                                    <?php
                                    $date = new DateTime($order["created_at"]);
                                    $date = $date->format('d/m/Y H:i:s');
                                    echo "<p class='text-gray-400 italic text-sm'>($date)</p>";
                                    ?>
                                </div>
                                <p class="text-gray-600">Total: $<?= $order["total"] ?>.00</p>
                                <p class="text-gray-600">Payment Method: card **** **** **** <?= $order["payment_method"] ?></p>
                                <p class="text-gray-600 line-clamp-2">Shipping Address: <?= $order["shipping_address"] ?></p>
                            </div>
                            <div class="w-1/4 flex flex-col justify-between items-end">
                                <?php
                                switch ($order["status"]) {
                                    case "pending":
                                        echo "<span class='bg-neutral-500 text-xs text-white px-2 py-1  rounded-3xl'>pending</span>";
                                        break;
                                    case "shipped":
                                        echo "<span class='bg-green-500 text-xs text-white px-2 py-1  rounded-3xl'>shipped</span>";
                                        break;
                                    case "delivered":
                                        echo "<span class='bg-blue-500 text-xs text-white px-2 py-1  rounded-3xl'>delivered</span>";
                                        break;
                                    case "canceled":
                                        echo "<span class='bg-red-500 text-xs text-white px-2 py-1  rounded-3xl'>canceled</span>";
                                        break;
                                    default:
                                        echo "<span class='bg-neutral-500 text-xs text-white px-2 py-1  rounded-3xl'>processing</span>";
                                        break;
                                }
                                ?>
                                <button class="text-red-800 underline">cancel</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php include __DIR__ . "/layout/footer.php"; ?>
</body>

</html>