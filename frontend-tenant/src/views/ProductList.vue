<template>
  <div class="product-list">
    <h1>Products</h1>
    <div class="product-cards">
      <div v-for="product in products" :key="product.id" class="product-card">
        <img :src="product.image" alt="Product Image" class="product-image" />
        <h2>{{ product.name }}</h2>
        <p>{{ product.description }}</p>
        <p><strong>Price:</strong> ${{ product.price }}</p>
        <button @click="addToCart(product)">Add to Cart</button>
      </div>
    </div>
    <router-link to="/cart">Go to Cart</router-link>
  </div>
</template>

<script>
export default {
    name: 'ProductList',
  data() {
    return {
      products: []
    };
  },
  methods: {
    async fetchProducts() {
      try {
        const response = await fetch('http://localhost:8000/api/products', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
          }
        });
        console.log("RESPONSE", response);
        
        this.products = await response.json();
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    },
    addToCart(product) {
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      const cartItem = cart.find(item => item.id === product.id);
      if (cartItem) {
        cartItem.quantity += 1;
      } else {
        cart.push({ ...product, quantity: 1 });
      }
      localStorage.setItem('cart', JSON.stringify(cart));
      alert(`${product.name} added to cart!`);
    }
  },
  mounted() {
    this.fetchProducts();
  }
};
</script>

<style scoped>
.product-list {
  padding: 20px;
}
.product-cards {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
}
.product-card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 15px;
  width: calc(33.333% - 20px);
  box-sizing: border-box;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
}
.product-image {
  width: 100%;
  height: 200px;
  object-fit: contain;
  margin-bottom: 15px;
}
button {
  padding: 10px 20px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
button:hover {
  background-color: #218838;
}
</style>
