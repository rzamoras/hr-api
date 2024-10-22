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
        $roles = Role::with('permissions')->get();

        return response()->json($roles);
    }

    public function permissions()
    {
        $permissions = Permission::get();

        return response()->json($permissions);
    }
}
