<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $permissions = Permission::get();

        foreach ($roles as $role) {
            $role_permissions = $role->permissions;
            $role->unassigned = $permissions->diff($role_permissions);
        }

        return response()->json($roles);
    }

    public function permissions()
    {
        $permissions = Permission::get();

        return response()->json($permissions);
    }
}
