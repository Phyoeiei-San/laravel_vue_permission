<?php

use App\Models\Role;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeatureController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('/users',UserController::class);
Route::get('/roles', [UserController::class, 'roles']);
Route::get('/users/{role}/permissions', [UserController::class, 'getPermissions']);
// Route::put('/users/{id}', [UserController::class, 'update']);

Route::apiResource('/roles',RoleController::class);
Route::get('/roles/{role}/permissions', [RoleController::class, 'getPermissions']);
Route::post('/roles/{role}/permissions', [RoleController::class, 'updatePermissions']);
Route::get('/features', [RoleController::class, 'feature']);

Route::apiResource('/features',FeatureController::class);
Route::get('/modules', [FeatureController::class, 'role_feature']);

// Route::get('/roles/{id}/permissions', [RoleController::class, 'getPermissions']);


// Route::get('/features', function () {
//     return response()->json([
//         'features' => Feature::with('permissions')->get(),
//     ]);
// });

// Route::get('/roles/{role}/permissions', function (Role $role) {
//     return response()->json([
//         'permissions' => $role->permissions()->pluck('id'),
//     ]);
// });

// Route::post('/roles/{role}/permissions', function (Role $role, Request $request) {
//     $role->permissions()->sync($request->permissions);
//     return response()->json(['message' => 'Permissions updated successfully!']);
// });


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
