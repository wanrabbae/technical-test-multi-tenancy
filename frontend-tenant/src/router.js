import { createRouter, createWebHistory } from 'vue-router';
import LoginView from './views/Login.vue';
import RegisterView from './views/Register.vue'; // Import the Register component

const routes = [
    {
        path: '/',
        name: 'LoginView',
        component: LoginView
    },
    {
        path: '/register',
        name: 'RegisterView',
        component: RegisterView
    },
    // Add more routes as needed
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
