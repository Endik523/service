<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\KerusakanController;




use App\Http\Controllers\KurirController;
use App\Http\Controllers\RegisterController;







Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);



// Route untuk menampilkan form registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

// Route untuk memproses registrasi
Route::post('/register', [RegisterController::class, 'register']);




// routes/api.php
Route::group(['prefix' => 'kurir'], function () {
    // Get orders for courier
    Route::get('/orders', [KurirController::class, 'getOrders']);

    // Update order status
    Route::put('/orders/{id}/status', [KurirController::class, 'updateStatus']);

    // Update courier location
    Route::put('/location', [KurirController::class, 'updateLocation']);
});


// // Halaman PWA Kurir
Route::get('/kurir', [KurirController::class, 'index'])->name('kurir.index');

Route::put('/kurir/update-location', [KurirController::class, 'updateLocation']);
Route::get('/kurir/location/{id}', [KurirController::class, 'getLocation']);

// API untuk PWA
Route::get('/api/kurir/orders', [KurirController::class, 'apiOrders']);
Route::post('/api/kurir/confirm-pickup/{orderId}', [KurirController::class, 'confirmPickup']);


Route::get('/status', [StatusController::class, 'show'])->name('status');
Route::get('/download-pdf/{orderId}', [StatusController::class, 'downloadPaymentReceipt'])->name('download.pdf');



Route::get('/isi', function () {
    return view('isi');
})->name('isi');
Route::get('/admin/isi', [IsiController::class, 'form'])->name('admin.isi');
Route::post('/isi', [IsiController::class, 'store'])->name('isi.store');



Route::get('/', [DashboardController::class, 'showOrders'])->middleware('auth')->name('dashboard');


Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');

Route::get('/form', function () {
    return view('form');
})->name('form');

Route::get('/calender', function () {
    return view('backoffice/calender');
})->name('calender');


Route::get('/kerusakan', function () {
    return view('kerusakan/index');
})->name('kerusakan');


Route::get('/create', function () {
    return view('kerusakan/create');
})->name('kerusakan.create');


Route::get('/store', function () {
    return view('kerusakan/store');
})->name('kerusakan.store_view');
