<?php

use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Laravel\Passport\Http\Controllers\AccessTokenController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Group routes that are controlled by the UserController
Route::controller(UserController::class)->group(function () {
    // Defines a POST route for user login handled by the 'loginUser' method in UserController
    Route::post('login', 'loginUser');
});

// Group routes that are controlled by the UserController
Route::controller(UserController::class)->group(function () {
    // Defines a GET route for logging out a user, handled by the 'userLogout' method in UserController
    Route::get('logout', 'userLogout');

    // Prefixing routes under "User" for User-related actions
    Route::prefix("user")->group(function () {
        // Storing a new User
        Route::post('/store',  'store');
        // Listing all User
        Route::get('/list',    'index');
        // Showing a specific User 
        Route::get('/show',    'show');
        // Updating a User 
        Route::post('/update', 'update');
        // Deleting a User 
        Route::post('/delete', 'delete');
    });

    // Prefixing routes under "permission" for Permission-related actions
    Route::prefix("permission")->group(function () {
        // Storing a new permission
        Route::post('/store',   [PermissionController::class, 'store']);
        // Listing all permissions
        Route::get('/list',     [PermissionController::class, 'index']);
        // Showing a specific permission 
        Route::get('/show',     [PermissionController::class, 'show']);
        // Updating a permission 
        Route::post('/update',  [PermissionController::class, 'update']);
        // Deleting a permission 
        Route::post('/delete',  [PermissionController::class, 'delete']);
    });

    // Prefixing routes under "role" for role-related actions
    Route::prefix("role")->group(function () {
        // Storing a new Role
        Route::post('/store',  [RoleController::class, 'store']);
        // Listing all Role
        Route::get('/list',    [RoleController::class, 'index']);
        // Showing a specific Role 
        Route::get('/show',    [RoleController::class, 'show']);
        // Updating a Role 
        Route::post('/update', [RoleController::class, 'update']);
        // Deleting a Role 
        Route::post('/delete', [RoleController::class, 'delete']);
    });
})->middleware('auth:api'); // Applies the 'auth:api' middleware to all routes in this group
