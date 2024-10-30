<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Office;
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
        $request->validate([
            'user_name' => 'required|unique:users,user_name',
            'first_name' => 'required',
            'middle_name' => 'sometimes',
            'last_name' => 'required',
            'name_ext' => 'sometimes',
            'email' => 'sometimes|unique:users,email',
            'office_code' => 'required',
            'section_code' => 'sometimes',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ],
            [
                'password.confirmed' => 'Password Confirmation does not match',
                'office_code.required' => 'Department/ Office is required',
            ]);

        $user = new User($request->all());
        $user->save();

        $user->assignRole('USER');

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json($user);
    }

    public function restoreUser($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();

        return response()->json($user);
    }

    public function users()
    {
        $auth = Auth::user();

        $users = User::latest()
            ->with('office')
            ->when($auth->hasPermissionTo('user.restore'), function ($query) use ($auth) {
                $query->withTrashed();
            })
            ->paginate(5);

        return response()->json($users);
    }

    public static function user()
    {
        $user = Auth::user();
        return response()->json($user);
    }
}
