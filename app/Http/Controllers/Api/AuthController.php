<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected PermissionController $permissionController;

    public function __construct(PermissionController $permissionController) {
        $this->permissionController = $permissionController;
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'user_name' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only(['user_name', 'password']))) {
            $token = $request->user()->createToken('token');

            $permissions = PermissionController::userPermissions();
            $roles = PermissionController::userRoles();
            $auth = UserController::user();

            return response()->json([
                "auth" => $auth->original,
                "token" => $token->plainTextToken,
                "permissions" => $permissions->original,
                "roles" => $roles->original,
            ]);
        }

        return response()->json(["message" => 'Username and Password not match'], 401);
    }

    public function changeDefaultPassword(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);

        $user = User::where('user_name', $request->user_name)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json("Password Changed");
    }
}
