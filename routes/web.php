<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use Illuminate\Support\Facades\Route;



Route::get('/', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');

Route::middleware('admin')->group(function () {
  Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.index');
  Route::post('admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

  // colors
  Route::resource('colors', ColorController::class, [
    'names' => [
      'index' => 'admin.colors.index',
      'create' => 'admin.colors.create',
      'store' => 'admin.colors.store',
      'edit' => 'admin.colors.edit',
      'update' => 'admin.colors.update',
      'destroy' => 'admin.colors.destroy',
    ]
  ]);
  // sizes
  Route::resource('sizes', SizeController::class, [
    'names' => [
      'index' => 'admin.sizes.index',
      'create' => 'admin.sizes.create',
      'store' => 'admin.sizes.store',
      'edit' => 'admin.sizes.edit',
      'update' => 'admin.sizes.update',
      'destroy' => 'admin.sizes.destroy',
    ]
  ]);
});
