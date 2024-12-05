let favoriteButtons;
let cartButtons;
const state_counter = document.getElementById("cart-counter");

function setInteractivity() {
  favoriteButtons = document.querySelectorAll(".favorite-button");
  cartButtons = document.querySelectorAll(".cart-button");

  favoriteButtons.forEach((button) => {
    const product = JSON.parse(button.dataset.product);

    updateFavoriteIcon(button, product.id);

    button.addEventListener("click", () => {
      if (GlobalState.isFavorite(product.id)) {
        GlobalState.removeFavorite(product.id);
      } else {
        GlobalState.addFavorite(product);
      }
      updateFavoriteIcon(button, product.id);
    });
  });

  cartButtons.forEach((button) => {
    const product = JSON.parse(button.dataset.product);
    console.log(button);

    updateCartIcon(button, product.id);

    button.addEventListener("click", () => {
      if (GlobalState.isInCart(product.id)) {
        GlobalState.removeFromCart(product.id);
      } else {
        GlobalState.addToCart(product);
      }
      updateCartIcon(button, product.id);
      updateStateCounter();
    });
  });
}

function updateFavoriteIcon(button, productId) {
  const icon = button.querySelector(".favorite-icon");
  if (GlobalState.isFavorite(productId)) {
    icon.classList.add("text-red-500");
    icon.classList.remove("text-gray-400");
  } else {
    icon.classList.remove("text-red-500");
    icon.classList.add("text-gray-400");
  }
}

function updateCartIcon(button, productId) {
  const icon = button.querySelector(".cart-icon");
  if (GlobalState.isInCart(productId)) {
    icon.classList.add("text-green-500");
    icon.classList.remove("text-gray-400");
  } else {
    icon.classList.remove("text-green-500");
    icon.classList.add("text-gray-400");
  }
}

function updateStateCounter() {
  let count = GlobalState.getUniqueCartItems();

  if (count > 0) {
    state_counter.textContent = count;
    state_counter.classList.remove("hidden");
  } else {
    state_counter.textContent = "";
    state_counter.classList.add("hidden");
  }
}

setInteractivity();
updateStateCounter();
