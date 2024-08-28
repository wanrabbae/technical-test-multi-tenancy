<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\Tenant;
use App\Models\TenantUser;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Tenant::create([
            'name' => 'Alwan',
            'db_name' => 'tenant_first_db',
            'db_username' => 'root',
            'db_password' => 'root',
        ]);

        TenantUser::create([
            'name' => 'Test User',
            'email' => 'alwan@gmail.com',
            'password' => bcrypt('123456'),
            'tenant_id' => 1,
        ]);

        Product::create([
            'name' => 'iPhone 15 Pro Max',
            'price' => 1500,
            'image' => '234234232p.webp',
            'description' => 'The latest iPhone model',
            'quantity' => 10,
        ]);

        Product::create([
            'name' => 'Macbook Pro M1 Max',
            'price' => 2500,
            'image' => '1028091313p.jpg',
            'description' => 'The latest Macbook model',
            'quantity' => 15,
        ]);
    }
}
