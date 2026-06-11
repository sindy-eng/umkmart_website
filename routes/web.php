<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminOnly;
use Illuminate\Support\Facades\Route;

// Welcome / Splash Screen
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// Auth Routes (Laravel Breeze)
require __DIR__.'/auth.php';

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products (accessible by all, but create/edit/delete restricted in views for Kasir)
    Route::resource('products', ProductController::class);
    Route::delete('/products/{product}/image', [ProductController::class, 'deleteImage'])->name('products.delete-image');

    // POS / Transactions
    Route::get('/pos', [TransactionController::class, 'pos'])->name('pos');
    Route::post('/pos', [TransactionController::class, 'store'])->name('pos.store');
    Route::resource('transactions', TransactionController::class)->only(['index', 'show', 'destroy']);
    Route::get('/transactions/{transaction}/struk', [TransactionController::class, 'struk'])->name('transactions.struk');

    // Customers (accessible by all, but create/edit/delete restricted in views for Kasir)
    Route::resource('customers', CustomerController::class);
    Route::get('/customers/{customer}/riwayat', [CustomerController::class, 'riwayat'])->name('customers.riwayat');

    // === Admin Only Routes ===
    Route::middleware([AdminOnly::class])->group(function () {
        // Promos
        Route::resource('promos', PromoController::class);
        Route::get('/promos/{promo}/broadcast', [PromoController::class, 'broadcastView'])->name('promos.broadcast');
        Route::post('/promos/{promo}/broadcast-log', [PromoController::class, 'broadcastLog'])->name('promos.broadcast-log');

        // Expenses
        Route::resource('expenses', ExpenseController::class);

        // Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');

        // Profile / Settings
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});
