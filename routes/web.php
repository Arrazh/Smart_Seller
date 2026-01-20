<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Seller\SalesController as SellerSalesController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (hanya bisa diakses kalau login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/dbpenjualan', [SellerSalesController::class, 'index'] 
)->name('dbpenjualan');

// Export data penjualan ke Excel
Route::get('/dbpenjualan/export', 
    [\App\Http\Controllers\Seller\SalesController::class, 'export']
)->name('dbpenjualan.export');

// Halaman aktivitas seller (list)
Route::get('/aktivitas', [SellerController::class, 'index'])
->name('aktivitas')
->middleware('auth');

// Export seller ke Excel
Route::get('/aktivitas/export', [SellerController::class, 'export'])
    ->name('aktivitas.export');

// Export data seller excel
Route::get('/data-seller/export', [SellerController::class, 'exportDataSeller'])
    ->name('data.seller.export');
    
// Halaman form tambah seller
Route::get('/add_seller', [SellerController::class, 'create'])->name('tambah_seller');

// Simpan seller baru
Route::post('add_seller', [SellerController::class, 'store'])->name('add_seller');

// ADMIN 
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/sales', [\App\Http\Controllers\Admin\SalesController::class, 'index'])
        ->name('admin.sales');
});

// SELLER
Route::get('/seller/sales/add', [\App\Http\Controllers\Seller\SalesController::class, 'create'])
    ->name('seller.sales.add');

Route::post('/seller/sales/store', [\App\Http\Controllers\Seller\SalesController::class, 'store'])
    ->name('seller.sales.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::patch('/seller/toggle/{seller}/{field}', [SellerController::class, 'toggle'])
->name('seller.toggle');

Route::get('/data-seller', [SellerController::class, 'data'])->name('data.seller');

Route::patch('/seller/sales/{sale}/status', [\App\Http\Controllers\Seller\SalesController::class, 'updateStatus'])
    ->name('seller.sales.updateStatus');

Route::delete(
    '/seller/sales/{sale}',
    [\App\Http\Controllers\Seller\SalesController::class, 'destroy']
)->name('seller.sales.destroy');

Route::delete('/seller/sales', [SellerSalesController::class, 'bulkDelete']
)->name('seller.sales.bulkDelete');

// DELETE SELLER
Route::delete('/seller/{seller}', [SellerController::class, 'destroy'])
->name('seller.destroy');

Route::delete('/sellers', [SellerController::class, 'bulkDelete'])
->name('sellers.bulkDelete');

// EDIT & UPDATE SELLER
Route::get('/seller/{seller}/edit', [SellerController::class, 'edit'])
->name('seller.edit');

Route::put('/seller/{seller}', [SellerController::class, 'update'])
->name('seller.update');

// EDIT & UPDATE
Route::get('/seller/sales/{sale}/edit', [SellerSalesController::class, 'edit'])
    ->name('seller.sales.edit');

Route::put('/seller/sales/{sale}', [SellerSalesController::class, 'update'])
    ->name('seller.sales.update');

Route::get('/dashboard/top-products', [DashboardController::class, 'topProducts'])
    ->middleware('auth');

Route::get('/dashboard/payment-methods', [DashboardController::class, 'paymentMethods'])
    ->middleware('auth');
