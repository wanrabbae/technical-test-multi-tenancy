<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_creation()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 19.99,
            'quantity' => 10,
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product'
        ]);
    }

    public function test_product_update()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 19.99,
            'quantity' => 10,
        ]);

        $product->update(['price' => 24.99]);

        $this->assertEquals(24.99, $product->fresh()->price);
    }

    public function test_product_deletion()
    {
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 19.99,
            'quantity' => 10,
        ]);

        $product->delete();

        $this->assertDatabaseMissing('products', [
            'name' => 'Test Product'
        ]);
    }
}
