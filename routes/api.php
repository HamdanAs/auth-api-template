<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Master\Supplier\ProductController;
use App\Http\Controllers\Api\Master\RoleController;
use App\Http\Controllers\Api\Master\StorageController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('api')->group(function(){
    Route::controller(AuthController::class)->prefix('auth')->group(function(){
        Route::post('register', 'save');
        Route::post('login', 'auth');
    });

    Route::get('/roles', [RoleController::class, 'all']);
});

Route::middleware(['api', 'auth:sanctum'])->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::any('logout', 'logout');
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/profile', [ProfileController::class, 'getProfile']);
});


