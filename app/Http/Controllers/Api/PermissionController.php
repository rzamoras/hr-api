<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(5);
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

    public static function userRoles()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        return response()->json($roles);
    }

    public static function userPermissions() {
        $user = Auth::user();
        $user->getPermissionsViaRoles();

        $permissions = [];
        foreach ($user->roles as $role) {
            $permissions = $role->permissions->pluck('name');
        }

        return response()->json($permissions);
    }
}
