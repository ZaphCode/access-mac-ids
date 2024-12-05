const favoriteContainer = document.getElementById("favorite-container");
const html = String.raw;

function renderFavorites() {
  const products = GlobalState.get(GlobalState.FAVORITES_KEY) || [];

  if (products.length === 0) {
    favoriteContainer.innerHTML = `
    <p class="col-span-full text-gray-500 text-center">
      You don't have any favorite products yet.
    </p>`;

    return;
  }

  favoriteContainer.innerHTML = "";

  products.forEach((product) => {
    const productCard = document.createElement("div");

    productCard.classList.add("bg-white", "h-72", "w-48", "mx-auto");
    productCard.innerHTML = `
      <div class="h-4/6  flex relative justify-center items-center">
        <!-- Add to Cart Button -->
        <button class="absolute top-2 left-2 remove-btn" data-product='${JSON.stringify(
          product
        )}'>
          <svg
            class="h-6 w-6 text-gray-400"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
          >
            <path stroke="none" d="M0 0h24v24H0z" />
            <line x1="18" y1="6" x2="6" y2="18" />
            <line x1="6" y1="6" x2="18" y2="18" />
          </svg>
        </button>
        <button
          class="absolute top-2 right-2 cart-button"
          data-product='${JSON.stringify(product)}'
        >
          <svg
            class="w-6 h-6 text-gray-400 cart-icon"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            fill="none"
            viewBox="0 0 24 24"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="1.6"
              d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7h-1M8 7h-.688M13 5v4m-2-2h4"
            />
          </svg>
        </button>
        <img
          class="w-5/6 max-h-32 object-scale-down"
          src="${product.image_src}"
          alt="${product.name}"
        />
      </div>
      <div class="flex pb-6 flex-col items-center justify-center h-1/6">
        <p class="text-sm font-bold">${product.name}</p>
        <p class="text-sm text-gray-500">$${product.price}</p>
      </div>
      <button class="w-full h-1/6 bg-black text-yellow-200">Shop now</button>
    `;

    favoriteContainer.appendChild(productCard);
  });

  for (const removeBtn of document.querySelectorAll(".remove-btn")) {
    removeBtn.addEventListener("click", () => {
      const product = JSON.parse(removeBtn.dataset.product);
      GlobalState.removeFavorite(product.id);
      renderFavorites();
    });
  }

  setInteractivity();
}

renderFavorites();
