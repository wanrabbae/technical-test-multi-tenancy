<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class TenantMiddleware
{
    public function handle($request, Closure $next)
    {
        $tenantId = auth()->user()->tenant_id;

        $tenant = Tenant::find($tenantId);

        config(['database.connections.tenant.database' => $tenant->db_name]);
        config(['database.connections.tenant.username' => $tenant->db_username]);
        config(['database.connections.tenant.password' => $tenant->db_password]);

        DB::setDefaultConnection('tenant');

        return $next($request);
    }
}
