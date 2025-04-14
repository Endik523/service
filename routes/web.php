<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsiController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\KerusakanController;



Route::get('/status', function () {
    return view('status');
})->name('status');

Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');

Route::get('/admin/form', [AdminController::class, 'form'])->name('admin.form');
Route::post('/admin1', [AdminController::class, 'store'])->name('admin');

Route::get('/form', function () {
    return view('form');
})->name('form');

Route::get('/isi', function () {
    return view('isi');
})->name('isi');
Route::get('/admin/isi', [IsiController::class, 'form'])->name('admin.isi');
Route::post('/isi', [IsiController::class, 'store'])->name('isi.store');


Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);

// Route::get('/', [DashboardController::class, 'showOrders'])->name('dashboard');
Route::get('/', [DashboardController::class, 'showOrders'])->middleware('auth')->name('dashboard');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/login1', function () {
//     return view('login');
// })->name('login1');


Route::get('/statusadmin', function () {
    return view('backoffice/statusadmin');
})->name('statusadmin');

Route::get('/payment', function () {
    return view('backoffice/paymentadmin');
})->name('payment');


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




// Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');


// Route::get('/', function () {
//     return view('dashboard');
// })->name('dashboard');

// Route::get('/homeadmin', function () {
//     return view('backoffice/homeadmin');
// })->name('homeadmin');

// Route::get('/kerusakan', [KerusakanController::class, 'index'])->name('kerusakan');
// Route::get('/kerusakan/create', [KerusakanController::class, 'create'])->name('kerusakan.create');
// Route::post('/kerusakan/store', [KerusakanController::class, 'store'])->name('kerusakan.store');
// Route::get('/status/{id}', [KerusakanController::class, 'showKerusakan'])->name('status');
// Route::get('/status', [KerusakanController::class, 'showKerusakan'])->name('status');

// Route::get('/status/{id}', [KerusakanController::class, 'showStatus'])->name('status.page');

// Rute untuk form admin dan penambahan pesanan
// Route::get('/admin/form', [KerusakanController::class, 'showForm'])->name('admin.form');
// Route::post('/admin/orders', [KerusakanController::class, 'store'])->name('order.store');

// Route::get('/admin/isi', [KerusakanController::class, 'showForm'])->name('admin.form');
// Route::post('/admin/orders', [KerusakanController::class, 'store'])->name('order.store');
