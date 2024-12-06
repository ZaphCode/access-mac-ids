if (GlobalState.getUniqueCartItems() === 0) {
  window.location.href = "/public";
} else {
  const cartSummary = document.getElementById("cart-summary");
  const totalSpan = document.getElementById("total");
  const productsInput = document.getElementById("products-input");

  const cart = GlobalState.get(GlobalState.CART_KEY);

  cart.forEach(({ product, quantity }) => {
    const productDiv = document.createElement("div");
    productDiv.classList.add("flex", "flex-col", "items-start");
    productDiv.innerHTML = `
        <p class="text-gray-600 truncate w-11/12"><span class="font-bold text-lg">${quantity} x </span> ${
      product.name
    }</p>
        <p class="text-gray-400 pl-7 mb-2">$${product.price * quantity}.00</p>
    `;
    cartSummary.appendChild(productDiv);
  });

  const total = cart.reduce(
    (acc, { product, quantity }) => acc + product.price * quantity,
    0
  );

  totalSpan.innerText = `${total}.00`;

  productsInput.value = JSON.stringify(
    cart.map(({ product, quantity }) => ({
      id: product.id,
      name: product.name,
      price: product.price,
      quantity,
    }))
  );
}
