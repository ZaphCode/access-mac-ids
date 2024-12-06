<?php
require_once __DIR__ . "/../utils/imports.php";

if (!isUserLogged()) {
    require_once __DIR__ . '/../views/login.php';
    exit();
}

$pdo = getPDO();

$userStorage = new UserStorage($pdo);
$orderStorage = new OrderStorage($pdo);
$productStorage = new ProductStorage($pdo);

$user = $userStorage->getUserByEmail(getAuthUser());

if ($user["role"] !== "admin") {
    header("Location: /public");
    exit();
}

$orders = $orderStorage->getAll();
$products = $productStorage->getAllProducts();
$users = $userStorage->getAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <script src="/public/scripts/admin.js" defer></script>
    <title>Admin</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="w-3/4 lg:w-2/3 xl:w-1/2 mx-auto mb-12">
        <div class="mx-auto mb-5 border-b-2 border-gray-300 pb-4 w-full flex justify-center mt-10">
            <button id="product-btn" class="text-gray-600">Products</button>
            <span class="text-2xl text-gray-300 mx-2 -mb-1">/</span>
            <button id="order-btn" class="text-gray-600">Orders</button>
            <span class="text-2xl text-gray-300 mx-2 -mb-1">/</span>
            <button id="user-btn" class="text-gray-600">Users</button>
        </div>
        <div id="notifications"></div>
        <div id="products-tab" class="hidden">
            <div class="flex mx-auto flex-col max-h-[440px] overflow-scroll items-center w-full md:w-2/3 lg:w-4/5 gap-y-3">
                <?php foreach ($products as $product) : ?>
                    <div class="bg-white w-full flex p-5 rounded-md ">
                        <div class="pr-4 pt-2">
                            <img class="h-20 my-auto object-scale-down" src="<?= $product["image_src"] ?>" class="w-20 h-20 object-cover rounded-md" alt="product">
                        </div>
                        <div class="w-3/4 pl-1">
                            <h3 class="font-bold text-lg text-gray-800"><?= $product["name"] ?> id(#<?= $product["id"] ?>)</h3>
                            <p class="text-gray-600 font-semibold">Price: $<?= $product["price"] ?>.00</p>
                            <p class="text-gray-500 line-clamp-2"><?= $product["description"] ?></p>
                        </div>
                        <div class="w-1/4 flex flex-col justify-between items-end">
                            <a href="/product-form?update&id=<?= $product["id"] ?>" class="text-purple-800 underline">edit</a>
                            <button class="text-red-800 underline delete-prod-btn" data-id="<?= $product["id"] ?>">delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="flex mt-6 justify-center">
                <a href="/product-form" class="bg-black text-yellow-200 rounded-md px-3 py-2">+ Create new Product</a>
            </div>
        </div>
        <div id="orders-tab" class="hidden">
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
                                <p class="text-gray-600">User: <span class="font-semibold text-gray-700">id(#<?= $order["user_id"] ?>)</span></p>
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
                                <button class="text-purple-800 underline">edit</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div id="users-tab" class="hidden">
            <div class="flex mx-auto flex-col items-center w-full md:w-2/3 lg:w-4/5 gap-y-3">
                <?php foreach ($users as $user) : ?>
                    <div class="bg-white w-full flex p-4 rounded-md ">
                        <div class="w-3/4">
                            <div class="flex gap-x-3 items-center">
                                <h3 class="font-bold text-lg text-gray-800"><?= $user["username"] ?> id(#<?= $user["id"] ?>)</h3>
                                <p class="text-gray-400 "><?= $user["email"] ?></p>
                            </div>
                            <p class="text-gray-600">Role: <span class="font-semibold text-gray-700"><?= $user["role"] ?></span></p>
                        </div>
                        <div class="w-1/4 flex flex-col justify-between items-end">
                            <button class="text-purple-800 underline">edit</button>
                            <button class="text-red-800 underline">delete</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
    </main>
    <script>
        const deleteProdButtons = document.querySelectorAll(".delete-prod-btn");
        deleteProdButtons.forEach(btn => {
            btn.addEventListener("click", async () => {
                // ASK FOR CONFIRMATION
                const confirmation = confirm("Are you sure you want to delete this product?");

                if (confirmation) {
                    const id = btn.dataset.id;
                    window.location.href = `/product-delete?id=${id}`;
                } else {
                    console.log("Product deletion canceled.");
                }
            });
        });
    </script>
    <?php if (isset($_GET["success"])) : ?>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const success = <?= json_encode($_GET["success"]) ?>;

                let message = "";
                switch (success) {
                    case "1":
                        message = "Product updated successfully!";
                        break;
                    case "2":
                        message = "Product created successfully!";
                        break;
                    case "3":
                        message = "Product deleted successfully!";
                        break;
                    default:
                        message = "Action completed successfully!";
                        break;
                }

                // Create a notification element
                const notification = document.createElement("div");
                notification.textContent = message;
                notification.className = "fixed top-20 right-5 bg-yellow-500 text-white py-2 px-4 rounded shadow-lg transition-opacity duration-500 ease-in-out opacity-0";
                document.body.appendChild(notification);

                // Show the notification
                setTimeout(() => {
                    notification.classList.add("opacity-100");
                }, 100);

                // Hide after 3 seconds
                setTimeout(() => {
                    notification.classList.remove("opacity-100");
                    notification.classList.add("opacity-0");
                    setTimeout(() => notification.remove(), 500); // Remove after fade out
                }, 3000);
            });
        </script>
    <?php endif; ?>
    <?php include __DIR__ . "/layout/footer.php"; ?>
</body>

</html>