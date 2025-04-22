<?php

use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{color}/color', [ProductController::class, 'filterProductsByColor']);
Route::get('/product/{size}/size', [ProductController::class, 'filterProductsBySize']);
Route::get('/product/{searchTerm}/find', [ProductController::class, 'findProductsByTerm']);
Route::get('/product/{product}/show', [ProductController::class, 'show']);
