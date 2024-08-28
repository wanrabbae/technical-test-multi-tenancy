import { createRouter, createWebHistory } from 'vue-router';
import Login from './views/Login.vue';
import Register from './views/Register.vue';
import ProductList from './views/ProductList.vue';
import CartView from './views/Cart.vue';

const routes = [
    { path: '/', name: 'Login', component: Login },
    { path: '/register', name: 'Register', component: Register },
    { path: '/products', name: 'ProductList', component: ProductList },
    { path: '/cart', name: 'CartView', component: CartView },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
