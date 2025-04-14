<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showOrders(): View
    {
        // Ambil user_id dari pengguna yang sedang login
        $userId = Auth::id();

        // Cara 1: Menggunakan Auth facade langsung
        if (Auth::check()) {
            $orders = Auth::user()->orders;
        } else {
            $orders = collect(); // Membuat collection kosong jika tidak ada user
        }
        // Atau cara alternatif - menggunakan relasi langsung
        // $orders = Order::where('user_id', $userId)->get();

        // Tampilkan view dengan data orders
        return view('dashboard', ['orders' => $orders]);
    }
}
