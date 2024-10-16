<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class ITAdministratorPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $it_admin = Role::where('name', 'IT ADMINISTRATOR')->first();

        if ($it_admin) {
            $permissions = Permission::All();

            $new_permissions = $permissions->reject(function ($permission) use ($it_admin) {
                return $it_admin->hasPermissionTo($permission);
            });

            if ($new_permissions->isNotEmpty()) {
                foreach ($new_permissions as $permission) {
                    $it_admin->givePermissionTo($permission);
                }
            }
        }

        return $next($request);
    }
}
