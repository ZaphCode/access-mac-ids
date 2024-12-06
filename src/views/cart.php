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
        <div id="cart-container" class="pt-3 max-h-96 px-10 overflow-y-auto">

        </div>
        <div class="w-1/2 hidden" id="checkout-container">
            <h3 class="text-lg text-gray-600 text-center border-t-2 pt-4 border-gray-300  font-semibold mt-2">Total: $<span id="total-price">0.00</span></h3>
            <div class="flex justify-center">
                <a href="/checkout" class="bg-black mx-auto text-yellow-200 py-2 px-4 rounded mt-5">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . "/layout/footer.php"; ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const html = String.raw;

            function renderCart() {
                const cartContainer = document.getElementById("cart-container");
                const cartItems = GlobalState.get(GlobalState.CART_KEY);
                const checkoutContainer = document.getElementById("checkout-container");
                const totalPriceElement = document.getElementById("total-price");

                cartContainer.innerHTML = "";

                if (cartItems.length === 0) {
                    checkoutContainer.classList.add("hidden");
                    totalPriceElement.textContent = "0.00";
                    cartContainer.innerHTML = `
                        <p class="text-gray-600 mb-8 text-center mt-5">
                            Your cart is empty. Start adding some products!
                        </p>`;
                    return;
                }

                cartItems.forEach(({
                    product,
                    quantity
                }) => {
                    const productHTML = html`
                    <div class="flex gap-4 items-center bg-white px-5 py-2 mb-3 rounded-md py-4 w-full">
                        <img src="${product.image_src}" alt="${product.name}" class="max-h-16 object-object-scale-down rounded">
                        <div class="flex flex-col flex-1 max-w-48 min-w-36  md:min-w-44">
                            <h3 class="text-lg font-semibold text-gray-700 truncate">${product.name}</h3>
                            <div class="text-lg text-gray-500">$${(product.price * quantity).toFixed(2)}</div>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="text-gray-700">Quantity:</span>
                            <input type="number" value="${quantity}" data-id="${product.id}" min="1" class="quantity-input w-12 outline-none text-center border rounded">
                        </div>
                        <button class="remove-button text-gray-400 hover:text-red-500" data-id="${product.id}">
                            <svg class="h-7 w-7" viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round">  <line x1="18" y1="6" x2="6" y2="18" />  <line x1="6" y1="6" x2="18" y2="18" /></svg>
                        </button>
                    </div>
                    `;
                    cartContainer.innerHTML += productHTML;
                });


                const totalPrice = cartItems.reduce((acc, {
                    product,
                    quantity
                }) => acc + product.price * quantity, 0);

                totalPriceElement.textContent = totalPrice.toFixed(2);
                checkoutContainer.classList.remove("hidden");
                setupCartInteractions();
            }

            function setupCartInteractions() {
                const removeButtons = document.querySelectorAll(".remove-button");
                const quantityInputs = document.querySelectorAll(".quantity-input");

                removeButtons.forEach((button) => {
                    const productId = button.dataset.id;
                    button.addEventListener("click", () => {
                        GlobalState.removeFromCart(parseInt(productId));
                        renderCart();
                        updateStateCounter();
                    });
                });

                quantityInputs.forEach((input) => {
                    input.addEventListener("change", (e) => {
                        const newQuantity = parseInt(e.target.value);
                        const productId = input.dataset.id;

                        if (newQuantity > 0) {
                            GlobalState.updateCartQuantity(parseInt(productId), newQuantity);
                            renderCart();
                        } else {
                            e.target.value = 1;
                        }
                    });
                });
            }

            renderCart();
        });
    </script>
</body>

</html>