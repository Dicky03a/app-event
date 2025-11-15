<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\TicketController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [FrontController::class, 'adminDashboard'])->name('admin.dashboard');
Route::get('/admin/category', [CategoryController::class, 'index'])->name('admin.category');
Route::get('/admin/ticket', [TicketController::class, 'index'])->name('admin.ticket');

// Category routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show', 'create']);

    // Additional route for edit modal data
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

    // Ticket routes
    Route::resource('tickets', TicketController::class);
    Route::delete('tickets/{ticket}/photos/{photo}', [TicketController::class, 'removePhoto'])
        ->name('tickets.photos.destroy');
});
