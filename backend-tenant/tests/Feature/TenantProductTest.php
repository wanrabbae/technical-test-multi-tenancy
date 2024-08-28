<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class TenantProductTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Set up tenants and their databases
        Tenant::create([
            'tenant_name' => 'Tenant1',
            'db_name' => 'tenant1_db',
            'db_username' => 'tenant1_user',
            'db_password' => 'password',
        ]);

        Tenant::create([
            'tenant_name' => 'Tenant2',
            'db_name' => 'tenant2_db',
            'db_username' => 'tenant2_user',
            'db_password' => 'password',
        ]);

        // Simulate tenant context switching
        $this->setTenantDatabase('tenant1');
    }

    protected function setTenantDatabase($tenantName)
    {
        $tenant = Tenant::where('tenant_name', $tenantName)->first();

        config(['database.connections.tenant.database' => $tenant->db_name]);
        config(['database.connections.tenant.username' => $tenant->db_username]);
        config(['database.connections.tenant.password' => $tenant->db_password]);

        DB::setDefaultConnection('tenant');
    }

    public function test_tenant1_can_create_product()
    {
        $this->postJson('/api/products', [
            'name' => 'Tenant1 Product',
            'description' => 'This is a product for Tenant1.',
            'price' => 19.99,
            'quantity' => 10,
        ])->assertStatus(201);

        $this->assertDatabaseHas('products', ['name' => 'Tenant1 Product']);
    }

    public function test_tenant2_has_no_access_to_tenant1_products()
    {
        // Switch to Tenant2
        $this->setTenantDatabase('tenant2');

        // Check that Tenant2 cannot access Tenant1's products
        $this->getJson('/api/products')
            ->assertJsonMissing(['name' => 'Tenant1 Product']);
    }
}
