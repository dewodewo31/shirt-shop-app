<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
  Route::get('user', function (Request $request) {
    return [
      'user' => UserResource::make($request->user()),
      'access_token' => $request->bearerToken()
    ];
  });
  Route::post('user/logout', [UserController::class, 'logout']);
  Route::put('user/profile/update', [UserController::class, 'UpdateUserProfile']);
});
// product
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{color}/color', [ProductController::class, 'filterProductsByColor']);
Route::get('/product/{size}/size', [ProductController::class, 'filterProductsBySize']);
Route::get('/product/{searchTerm}/find', [ProductController::class, 'findProductsByTerm']);
Route::get('/product/{product}/show', [ProductController::class, 'show']);

// user
Route::post('user/register', [UserController::class, 'store']);
Route::post('user/login', [UserController::class, 'auth']);
