<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleDetailController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/category/data', [CategoryController::class, 'data'])->name('category.data');
    Route::resource('/category', CategoryController::class);

    Route::get('/product/data', [ProductController::class, 'data'])->name('product.data');
    Route::post('/product/delete-selected', [ProductController::class, 'deleteSelected'])->name('product.delete-selected');
    Route::resource('/product', ProductController::class);

    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/data/{startDate}/{endDate}', [ReportController::class, 'data'])->name('report.data');

    Route::get('/report/export/{startDate}/{endDate}', [ExportController::class, 'export'])->name('report.export');

    Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
    Route::resource('/user', UserController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/transaction/new', [SaleController::class, 'create'])->name('transaction.new');
    Route::post('/transaction/save', [SaleController::class, 'store'])->name('transaction.save');

    Route::get('/transaction/{id}/data', [SaleDetailController::class, 'data'])->name('transaction.data');
    Route::get('/transaction/loadform/{total}/{received}', [SaleDetailController::class, 'loadForm'])->name('transaction.load-form');
    Route::resource('/transaction', SaleDetailController::class)->except(['create', 'show', 'edit']);

    Route::get('/sale/data', [SaleController::class, 'data'])->name('sale.data');
    Route::get('/sale', [SaleController::class, 'index'])->name('sale.index');
    Route::get('/sale/print', [SaleController::class, 'print'])->name('sale.print');
    Route::get('/sale/{id}', [SaleController::class, 'show'])->name('sale.show');
    Route::get('/sale/{id}/edit', [SaleController::class, 'edit'])->name('sale.edit');
    Route::delete('/sale/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
});

require __DIR__ . '/auth.php';
