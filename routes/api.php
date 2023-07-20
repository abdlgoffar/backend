<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/users', [UserController::class, 'register']);
Route::post('/auth', [AuthController::class, 'auth']);


Route::middleware([EnsureTokenIsValid::class])->group(function () {

    Route::get('/users', [UserController::class, 'get']);
    Route::delete('/logout', [AuthController::class, 'logOut']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'getById']);
    Route::put('/products/{id}', [ProductController::class, 'updateById']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);


    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'getById']);
    Route::put('/categories/{id}', [CategoryController::class, 'updateById']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
});
