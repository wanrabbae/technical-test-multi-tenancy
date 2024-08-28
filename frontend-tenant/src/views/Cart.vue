<template>
  <div class="cart">
    <h1>Your Cart</h1>
    <div v-if="cartItems.length > 0">
      <div v-for="item in cartItems" :key="item.id" class="cart-item">
        <h2>{{ item.name }}</h2>
        <p><strong>Quantity:</strong> {{ item.quantity }}</p>
        <p><strong>Price:</strong> ${{ item.price }}</p>
        <p><strong>Total:</strong> ${{ item.quantity * item.price }}</p>
        <button @click="removeFromCart(item.id)">Remove</button>
      </div>
      <p><strong>Total Price:</strong> ${{ totalPrice }}</p>
      <button @click="checkout">Checkout</button>
    </div>
    <div v-else>
      <p>Your cart is empty.</p>
    </div>
    <router-link to="/products">Continue Shopping</router-link>
  </div>
</template>

<script>
export default {
    name: 'CartView',
  data() {
    return {
      cartItems: []
    };
  },
  computed: {
    totalPrice() {
      return this.cartItems.reduce((sum, item) => sum + item.quantity * item.price, 0);
    }
  },
  methods: {
    loadCart() {
      this.cartItems = JSON.parse(localStorage.getItem('cart')) || [];
    },
    removeFromCart(productId) {
      this.cartItems = this.cartItems.filter(item => item.id !== productId);
      localStorage.setItem('cart', JSON.stringify(this.cartItems));
    },
    async checkout() {
      try {
        const response = await fetch('http://localhost:8000/api/cart/checkout', {
          method: 'POST',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ items: this.cartItems }),
        });

        const data = await response.json();
        if (response.ok) {
          alert('Checkout successful!');
          localStorage.removeItem('cart');
          this.cartItems = [];
          this.$router.push('/products');
        } else {
          alert('Checkout failed: ' + data.message);
        }
      } catch (error) {
        console.error('Error during checkout:', error);
      }
    }
  },
  mounted() {
    this.loadCart();
  }
};
</script>

<style scoped>
.cart {
  padding: 20px;
}
.cart-item {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 15px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
button {
  padding: 10px 20px;
  background-color: #dc3545;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #c82333;
}
</style>
