<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function showOrders(): View
    {
        // Ambil user_id dari pengguna yang sedang login
        $userId = Auth::id();
        // dd($userId);

        // Pastikan pengguna sudah login
        if (Auth::check()) {
            // Ambil hanya orders yang memiliki user_id sesuai dengan ID pengguna yang sedang login
            $orders = Order::where('user_id', $userId)->with('damageDetails')->get();
        } else {
            // Jika tidak ada user yang login, kembalikan koleksi kosong
            $orders = collect();
        }

        // Tampilkan view dengan data orders
        return view('dashboard', ['orders' => $orders]);
    }
}
