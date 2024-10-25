<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CsmResponseController;
use App\Http\Controllers\Api\PermissionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [AuthController::class, 'login']);
ROute::apiResources([
    '/csm-response' => CsmResponseController::class,
]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        '/role-permissions' => PermissionController::class,
    ]);

    Route::apiResources([
        '/user' => UserController::class,
    ]);

    Route::get('/get-permissions', [PermissionController::class, 'permissions']);

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/user-roles', 'userRoles');
        Route::get('/user-permissions', 'userPermissions');
    });
});
