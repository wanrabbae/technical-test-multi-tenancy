<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantService
{
    public static function createTenantDatabase($tenantName)
    {
        $dbName = 'tenant_' . strtolower($tenantName);
        $dbUsername = $dbName . '_user';
        $dbPassword = 'secure_password'; // Generate a secure password

        // Create the database
        DB::statement("CREATE DATABASE IF NOT EXISTS $dbName");

        // Create a user for the tenant
        DB::statement("CREATE USER '$dbUsername'@'localhost' IDENTIFIED BY '$dbPassword'");
        DB::statement("GRANT ALL PRIVILEGES ON $dbName.* TO '$dbUsername'@'localhost'");
        DB::statement("FLUSH PRIVILEGES");

        // Save tenant information to the master database
        Tenant::create([
            'tenant_name' => $tenantName,
            'db_name' => $dbName,
            'db_username' => $dbUsername,
            'db_password' => $dbPassword,
        ]);

        // Optionally, you can run migrations for the new tenant database
        Artisan::call('migrate', [
            '--database' => 'tenant', // You will define this connection below
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);
    }
}
