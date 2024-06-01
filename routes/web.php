<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::prefix('category')->name('category.')->group(function () {
        Route::get('data', [Controllers\CategoryController::class, 'data'])->name('data');
        Route::resource('/', Controllers\CategoryController::class)->parameters(['' => 'category']);
    });

    Route::prefix('product')->name('product.')->group(function () {
        Route::get('data', [Controllers\ProductController::class, 'data'])->name('data');
        Route::post('delete-selected', [Controllers\ProductController::class, 'deleteSelected'])->name('delete-selected');
        Route::resource('/', Controllers\ProductController::class)->parameters(['' => 'product']);
    });

    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/', [Controllers\ReportController::class, 'index'])->name('index');
        Route::get('data/{startDate}/{endDate}', [Controllers\ReportController::class, 'data'])->name('data');
        Route::get('export/{startDate}/{endDate}', [Controllers\ExportController::class, 'export'])->name('export');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::get('data', [Controllers\UserController::class, 'data'])->name('data');
        Route::resource('/', Controllers\UserController::class)->parameters(['' => 'user']);
    });
});

Route::middleware('auth')->group(function () {

    Route::prefix('transaction')->name('transaction.')->group(function () {
        Route::get('new', [Controllers\SaleController::class, 'create'])->name('new');
        Route::post('save', [Controllers\SaleController::class, 'store'])->name('save');
        Route::get('{id}/data', [Controllers\SaleDetailController::class, 'data'])->name('data');
        Route::get('loadform/{total}/{received}', [Controllers\SaleDetailController::class, 'loadForm'])->name('load-form');
        Route::resource('/', Controllers\SaleDetailController::class)
            ->except(['create', 'show', 'edit'])
            ->parameters(['' => 'transaction']);
    });

    Route::prefix('sale')->name('sale.')->group(function () {
        Route::get('data', [Controllers\SaleController::class, 'data'])->name('data');
        Route::get('/', [Controllers\SaleController::class, 'index'])->name('index');
        Route::get('print', [Controllers\SaleController::class, 'print'])->name('print');
        Route::get('{id}', [Controllers\SaleController::class, 'show'])->name('show');
        Route::get('{id}/edit', [Controllers\SaleController::class, 'edit'])->name('edit');
        Route::delete('{id}', [Controllers\SaleController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [Controllers\ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [Controllers\ProfileController::class, 'update'])->name('update');
        Route::post('/', [Controllers\ProfileController::class, 'store'])->name('store');
    });
});

require __DIR__ . '/auth.php';
