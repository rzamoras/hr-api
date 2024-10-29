<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function show($id)
    {
        $role = Role::where('id', $id)->with('permissions')->first();
        $role->all_permissions = Permission::all();
        $role->unassigned = $role->all_permissions->diff($role->permissions);

        return response()->json($role);
    }

    public function permissions()
    {
        $permissions = Permission::get();

        return response()->json($permissions);
    }

    public function revokeRolePermission(Request $request) {
        $role = Role::where('id', $request->role_id)->with('permissions')->first();
        $permission = Permission::where('id', $request->permission_id)->first();
        $role->revokePermissionTo($permission);

        return response()->json('Permission revoked');
    }

    public function assignRolePermission(Request $request) {
        $role = Role::where('id', $request->role_id)->with('permissions')->first();
        $permission = Permission::where('id', $request->permission_id)->first();
        $role->givePermissionTo($permission);

        return response()->json('Permission assigned');
    }

    public static function userRoles()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();

        return response()->json($roles);
    }

    public static function userPermissions()
    {
        $user = Auth::user();
        $user->getPermissionsViaRoles();

        $permissions = [];
        foreach ($user->roles as $role) {
            $permissions = $role->permissions->pluck('name');
        }

        return response()->json($permissions);
    }
}
