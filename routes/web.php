<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Backend\CategoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [FrontController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');

// Category routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show', 'create']);

    // Additional route for edit modal data
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
});
