<?php
require_once __DIR__ . "/../utils/imports.php";

$pdo = getPDO();
$stmt = $pdo->query("SELECT VERSION()");
$version = $stmt->fetchColumn();
$prodStorage = new ProductStorage($pdo);
$products = $prodStorage->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/public/scripts/index.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Home</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <h2 class="text-neutral-900 font-bold text-lg">Hello World! 👋🌎</h2>
    <i><?php echo "Versión de MySQL: $version"; ?></i>
    <p>Esta es una página de prueba, solo para verificar la correcta conexión de la base de datos.</p>
    <button onclick="handleClick()">Click Me</button>


    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
        <?php foreach ($products as $product) : ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <!-- Imagen del producto -->
                <img src="<?php echo $product['image_src']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-contain">

                <!-- Contenido de la tarjeta -->
                <div class="p-3">
                    <h3 class="text-sm font-bold text-gray-800 truncate"><?php echo $product['name']; ?></h3>
                    <p class="text-gray-600 text-xs mt-1 truncate"><?php echo $product['description']; ?></p>
                    <p class="text-gray-800 font-semibold mt-2 text-sm">$<?php echo $product['price']; ?></p>
                    <p class="text-gray-600 text-xs">Stock: <?php echo $product['stock']; ?></p>

                    <!-- Botón de acción -->
                    <div class="mt-3">
                        <button class="w-full bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 text-xs rounded">
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</body>

</html>