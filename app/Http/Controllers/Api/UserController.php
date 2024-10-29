<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $user = Auth::user();
        $permissions = PermissionController::userPermissions();
        $roles = PermissionController::userRoles();

        return response()->json([
            "user" => $user,
            "permissions" => $permissions->original,
            "roles" => $roles->original,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = new User();

        $request->validate([
            'username' => 'required|unique:users,username',
            'first_name' => 'required',
            'email' => 'sometimes|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ],
            [
                'password.confirmed' => 'Password Confirmation does not match'
            ]);

        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->name_ext = $request->input('name_ext');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return response()->json($user, 200);
    }

    public function users()
    {
        $users = User::paginate(10);

        return response()->json($users);
    }
}
