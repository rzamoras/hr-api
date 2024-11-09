<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CsmResponseController;
use App\Http\Controllers\Api\OfficeController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\ServicesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/change-default-password', [AuthController::class, 'changeDefaultPassword']);
ROute::apiResources([
    '/csm-response' => CsmResponseController::class,
    '/services' => ServicesController::class
]);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        '/role-permissions' => PermissionController::class,
        '/user' => UserController::class,
        '/offices' => OfficeController::class,
    ]);

    Route::controller(PermissionController::class)->group(function () {
        Route::get('/get-permissions', 'permissions');
        Route::get('/get-roles', 'roles');
        Route::get('/user-roles', 'userRoles');
        Route::get('/user-permissions', 'userPermissions');
        Route::post('/revoke-role-permission', 'revokeRolePermission');
        Route::post('/assign-role-permission', 'assignRolePermission');
        Route::get('/get-role-permissions/{id}', 'rolePermissions');
        Route::post('/sync-user-roles', 'syncUserRoles');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'users');
        Route::post('/restore-user/{id}', 'restoreUser');
        Route::post('/modify-user/{id}', 'modifyUser');
    });

    Route::controller(OfficeController::class)->group(function () {
        Route::post('/import-offices', 'importOffices');
        Route::get('/get-section/{id}', 'section');
        Route::get('/sections', 'sections');
    });

    Route::controller(ServicesController::class)->group(function () {
        Route::get('/all-services', 'allServices');
    });

    Route::controller(CsmResponseController::class)->group(function () {
        Route::get('/get-client-transactions', 'clientTransactions');
        Route::get('/get-other-transactions', 'otherTransactions');
        Route::get('/get-responses', 'responses');
        Route::get('/generate-csm-report', 'generateCsmReport');
    });
});

Route::prefix('desktop')->group(function () {
    Route::controller(CsmResponseController::class)->group(function () {
        Route::get('/get-client-transactions', 'desktopTransactions');
    });
});
