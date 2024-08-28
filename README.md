# Multi-Tenant eCommerce Platform

<!-- list of contents -->
- [Overview](#overview)
- [Architecture](#architecture)
  - [Multi-Tenancy with Multi-Database](#multi-tenancy-with-multi-database)
  - [Key Components](#key-components)
- [Page Preview](#page-preview)
    - [Login Page](#login-page)
    - [Register Page](#register-page)
    - [Products Page](#products-page)
    - [Cart Page](#cart-page)
- [Project Setup](#project-setup)
    - [Laravel Backend](#laravel-backend)
    - [Vue.js Frontend](#vuejs-frontend)


## Overview

This project is a multi-tenant eCommerce platform built using Laravel for the backend and Vue.js for the frontend. Each tenant (store) has its own dedicated database, ensuring data isolation and security. The application supports CRUD operations for products, shopping cart functionality, user authentication, and more.

## Architecture

### Multi-Tenancy with Multi-Database

- **Tenant Database Isolation:** Each tenant has its own dedicated database. This is implemented to ensure data isolation, security, and scalability.
- **Dynamic Database Switching:** The application dynamically switches between tenant databases based on the current tenant's context, ensuring that all operations are isolated to the relevant tenant.
- **User Authentication:** Users are authenticated within the context of their tenant, ensuring that user data is also isolated.

### Key Components

- **Laravel Backend:**
  - **Models:** `Tenant`, `User`, `Product`, `Cart`, `CartItem`
  - **Controllers:** `AuthController`, `ProductController`, `CartController`
  - **Middleware:** `TenantMiddleware` for dynamic database switching.
- **Vue.js Frontend:**
  - **Pages:** `Login`, `Register`, `ProductList`, `Cart`
  - **State Management:** Using `localStorage` for cart persistence.
  - **Routing:** Handled by Vue Router with protected routes for authenticated users.

## Page Preview

### Login Page
<img src='https://raw.githubusercontent.com/wanrabbae/technical-test-multi-tenancy/main/frontend-tenant/src/assets/login.png'>

### Register Page
<img src='https://raw.githubusercontent.com/wanrabbae/technical-test-multi-tenancy/main/frontend-tenant/src/assets/register.png'>

### Products Page
<img src='https://raw.githubusercontent.com/wanrabbae/technical-test-multi-tenancy/main/frontend-tenant/src/assets/products.png'>

### Cart Page
<img src='https://raw.githubusercontent.com/wanrabbae/technical-test-multi-tenancy/main/frontend-tenant/src/assets/cart.png'>

## Project Setup

### Laravel Backend

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/wanrabbae/technical-test-multi-tenancy
   cd technical-test-multi-tenancy/backend-tenant
    ```
2. **Install Dependencies:**

   ```bash
   composer install
   ```
3. **Set Up Environment Variables:**

   - Copy the `.env.example` file to `.env`:

     ```bash
     cp .env.example .env
     ```

   - Generate a new application key:

     ```bash
     php artisan key:generate
     ```

   - Update the database configuration in the `.env` file with your database credentials:

        ```bash
        DB_CONNECTION=mysql
        DB_HOST=localhost
        DB_PORT=your_port
        DB_DATABASE=your_database
        DB_USERNAME=your_username
        DB_PASSWORD=your_password
        ```
4. **Run Migrations:**

   ```bash
   php artisan migrate
   ```
5. **Start the Development Server:**

   ```bash
    php artisan serve
    ```
6. **Access the Application:**

   Open your browser and visit `http://localhost:8000`.

### Vue.js Frontend

1. **Install Dependencies:**

   ```bash
   npm install
   ```
2. **Start the Development Server:**

   ```bash
    npm run serve
    ```
3. **Access the Application:**

   Open your browser and visit `http://localhost:8080`.