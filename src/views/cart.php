<?php
include __DIR__ . "/../utils/imports.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . "/layout/header_links.php"; ?>
    <title>Cart</title>
</head>

<body>
    <?php include __DIR__ . "/layout/navbar.php"; ?>
    <main class="flex flex-col items-center justify-center">
        <h2 class="flex gap-x-2 mt-10 w-1/2 justify-center pb-3 border-b-2 border-gray-300 text-xl text-gray-600 font-semibold items-center">
            <svg class="w-10 h-10 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
            </svg>
            Cart
        </h2>
        <div id="cart-container">

        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            function renderCart() {
                const cartContainer = document.getElementById("cart-container");
                const cartItems = GlobalState.get(GlobalState.CART_KEY);

                // Limpiar el contenido actual del contenedor
                cartContainer.innerHTML = "";

                if (cartItems.length === 0) {
                    cartContainer.innerHTML = `
        <p class="text-gray-600 text-center mt-5">Your cart is empty. Start adding some products!</p>
      `;
                    return;
                }

                // Crear estructura para los productos del carrito
                cartItems.forEach(({
                    product,
                    quantity
                }) => {
                    const productHTML = `
        <div class="flex gap-4 items-center border-b py-4 w-1/2">
          <img src="${product.image_src}" alt="${product.name}" class="w-20 h-20 object-cover rounded">
          <div class="flex flex-col flex-1">
            <h3 class="text-lg font-semibold text-gray-700">${product.name}</h3>
            <p class="text-sm text-gray-500">${product.description}</p>
          </div>
          <div class="flex flex-col items-center">
            <span class="text-gray-600">Quantity:</span>
            <input type="number" value="${quantity}" min="1" class="quantity-input w-16 text-center border rounded">
          </div>
          <div class="text-lg font-semibold text-gray-700">$${(product.price * quantity).toFixed(2)}</div>
          <button class="remove-button text-red-500 hover:text-red-700" data-id="${product.id}">Remove</button>
        </div>
      `;
                    cartContainer.innerHTML += productHTML;
                });

                // Agregar interactividad a los botones de eliminar y entradas de cantidad
                setupCartInteractions();
            }

            // Configurar interactividad para eliminar productos y actualizar cantidades
            function setupCartInteractions() {
                const removeButtons = document.querySelectorAll(".remove-button");
                const quantityInputs = document.querySelectorAll(".quantity-input");

                // Configurar los botones de eliminar
                removeButtons.forEach((button) => {
                    const productId = button.dataset.id;
                    button.addEventListener("click", () => {
                        GlobalState.removeFromCart(parseInt(productId));
                        renderCart();
                        updateStateCounter();
                    });
                });

                // Configurar los inputs de cantidad
                quantityInputs.forEach((input) => {
                    input.addEventListener("change", (e) => {
                        const newQuantity = parseInt(e.target.value, 10);
                        const productId = input.closest(".remove-button").dataset.id;

                        if (newQuantity > 0) {
                            GlobalState.updateCartQuantity(productId, newQuantity);
                            renderCart();
                        } else {
                            e.target.value = 1;
                        }
                    });
                });
            }

            // Inicializar la vista del carrito
            renderCart();
        });
    </script>
</body>

</html>