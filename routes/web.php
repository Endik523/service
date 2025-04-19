<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\KerusakanController;




Route::get('/status', [StatusController::class, 'show'])->name('status');
Route::get('/download-pdf/{orderId}', [StatusController::class, 'downloadPaymentReceipt'])->name('download.pdf');



Route::get('/pembayaran', function () {
    return view('pembayaran');
})->name('pembayaran');

Route::get('/form', function () {
    return view('form');
})->name('form');

Route::get('/isi', function () {
    return view('isi');
})->name('isi');
Route::get('/admin/isi', [IsiController::class, 'form'])->name('admin.isi');
Route::post('/isi', [IsiController::class, 'store'])->name('isi.store');

Route::get('admin/login', function () {
    abort(404);  // Menampilkan halaman 404 jika seseorang mencoba mengakses /admin/login
});
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);


Route::get('/', [DashboardController::class, 'showOrders'])->middleware('auth')->name('dashboard');


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
