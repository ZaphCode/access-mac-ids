<?php
require_once __DIR__ . "/../utils/imports.php";

if (!isUserLogged()) {
    require_once __DIR__ . '/../views/login.php';
    exit();
}

$userStorage = new UserStorage(getPDO());
$user = $userStorage->getUserByEmail(getAuthUser());

$orderStorage = new OrderStorage(getPDO());

if (!isset($_GET['id'])) {
    header("Location: /public/account");
    exit();
}

$order = $orderStorage->getByID($_GET['id']);

if ($order['user_id'] !== $user['id']) {
    header("Location: /public/account");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <script src="/public/scripts/favorites.js" defer></script>
    <title>Order Confirmation</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="w-3/4 lg:w-2/3 xl:w-1/2 mx-auto mb-12">
        <div class="bg-green-100 text-green-800 p-6 rounded-lg shadow-md mt-8">
            <h1 class="text-2xl font-semibold mb-4">Thank you for your order!</h1>
            <p class="text-lg">Your order <strong>#<?= htmlspecialchars($order['id']) ?></strong> has been successfully received. We are processing it and will notify you when it's ready.</p>

            <div class="mt-4">
                <p><strong>Order Details:</strong></p>
                <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
                <p><strong>Total:</strong> $<?= number_format($order['total'], 2) ?></p>
                <p><strong>Order Date:</strong> <?= date('F j, Y, g:i a', strtotime($order['created_at'])) ?></p>
            </div>

            <div class="mt-6">
                <p>We appreciate your business. If you have any questions about your order, feel free to contact us.</p>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="/public/account" class="text-yellow-200 px-6 rounded-md py-3 bg-black">Back to your account</a>
        </div>
    </main>
    <?php include __DIR__ . "/layout/footer.php"; ?>
</body>

</html>