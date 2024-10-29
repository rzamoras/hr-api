<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CsmResponseController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::put('/change-password', [AuthController::class, 'changePassword']);
ROute::apiResources([
    '/csm-response' => CsmResponseController::class,
]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        '/role-permissions' => PermissionController::class,
        '/user' => UserController::class,
        '/offices' => OfficeController::class,
    ]);

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/get-permissions', 'permissions');
        Route::get('/user-roles', 'userRoles');
        Route::get('/user-permissions', 'userPermissions');
        Route::post('/revoke-role-permission', 'revokeRolePermission');
        Route::post('/assign-role-permission', 'assignRolePermission');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'users');
    });
});
