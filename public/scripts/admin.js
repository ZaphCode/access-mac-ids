const productBtn = document.getElementById("product-btn");
const orderBtn = document.getElementById("order-btn");
const userBtn = document.getElementById("user-btn");

const productsTab = document.getElementById("products-tab");
const ordersTab = document.getElementById("orders-tab");
const usersTab = document.getElementById("users-tab");

const url = new URL(window.location.href);

const setProducts = () => {
  productBtn.classList.value = "text-yellow-600 underline";
  orderBtn.classList.value = "text-gray-600";
  userBtn.classList.value = "text-gray-600";

  productsTab.classList.remove("hidden");
  ordersTab.classList.add("hidden");
  usersTab.classList.add("hidden");

  url.searchParams.set("tab", "products");
  window.history.pushState({}, "", url);
};

const setOrders = () => {
  productBtn.classList.value = "text-gray-600";
  orderBtn.classList.value = "text-yellow-600 underline";
  userBtn.classList.value = "text-gray-600";

  productsTab.classList.add("hidden");
  ordersTab.classList.remove("hidden");
  usersTab.classList.add("hidden");

  url.searchParams.set("tab", "orders");
  window.history.pushState({}, "", url);
};

const setUsers = () => {
  productBtn.classList.value = "text-gray-600";
  orderBtn.classList.value = "text-gray-600";
  userBtn.classList.value = "text-yellow-600 underline";

  productsTab.classList.add("hidden");
  ordersTab.classList.add("hidden");
  usersTab.classList.remove("hidden");

  url.searchParams.set("tab", "users");
  window.history.pushState({}, "", url);
};

productBtn.addEventListener("click", setProducts);
orderBtn.addEventListener("click", setOrders);
userBtn.addEventListener("click", setUsers);

const activeTab = url.searchParams.get("tab");
if (activeTab === "orders") {
  setOrders();
} else if (activeTab === "users") {
  setUsers();
} else {
  setProducts();
}
