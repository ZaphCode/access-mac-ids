class GlobalState {
  static FAVORITES_KEY = "favorites";
  static CART_KEY = "cart";

  // Obtener datos del localStorage o inicializar como un arreglo vacío
  static get(key) {
    const data = localStorage.getItem(key);
    return data ? JSON.parse(data) : [];
  }

  // Guardar datos en el localStorage
  static set(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
  }

  // Añadir producto a favoritos
  static addFavorite(product) {
    const favorites = this.get(this.FAVORITES_KEY);
    if (!favorites.find((p) => p.id === product.id)) {
      favorites.push(product);
      this.set(this.FAVORITES_KEY, favorites);
    }
  }

  // Eliminar producto de favoritos
  static removeFavorite(productId) {
    const favorites = this.get(this.FAVORITES_KEY);
    const updatedFavorites = favorites.filter((p) => p.id !== productId);
    this.set(this.FAVORITES_KEY, updatedFavorites);
  }

  // Verificar si un producto está en favoritos
  static isFavorite(productId) {
    const favorites = this.get(this.FAVORITES_KEY);
    return favorites.some((p) => p.id === productId);
  }

  // Añadir producto al carrito (o incrementar cantidad si ya existe)
  static addToCart(product, quantity = 1) {
    const cart = this.get(this.CART_KEY);
    const existingItem = cart.find((item) => item.product.id == product.id);

    if (existingItem) {
      // Incrementar la cantidad si el producto ya está en el carrito
      existingItem.quantity += quantity;
    } else {
      // Agregar un nuevo producto al carrito
      cart.push({ product, quantity });
    }

    this.set(this.CART_KEY, cart);
  }

  // Eliminar producto del carrito
  static removeFromCart(productId) {
    const cart = this.get(this.CART_KEY);
    const updatedCart = cart.filter((item) => item.product.id !== productId);
    this.set(this.CART_KEY, updatedCart);
  }

  // Actualizar cantidad de un producto en el carrito
  static updateCartQuantity(productId, quantity) {
    const cart = this.get(this.CART_KEY);
    const existingItem = cart.find((item) => item.product.id === productId);

    if (existingItem) {
      if (quantity <= 0) {
        // Eliminar el producto si la cantidad es 0 o negativa
        this.removeFromCart(productId);
      } else {
        existingItem.quantity = quantity;
        this.set(this.CART_KEY, cart);
      }
    }
  }

  // Verificar si un producto está en el carrito
  static isInCart(productId) {
    const cart = this.get(this.CART_KEY);
    return cart.some((item) => item.product.id === productId);
  }

  //vaciar carrito
  static emptyCart() {
    this.set(this.CART_KEY, []);
  }

  // Obtener la cantidad total de artículos en el carrito
  static getCartSize() {
    const cart = this.get(this.CART_KEY);
    return cart.reduce((total, item) => total + item.quantity, 0);
  }

  // Obtener el total de productos únicos en el carrito
  static getUniqueCartItems() {
    return this.get(this.CART_KEY).length;
  }
}
