<?php


namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class KurirController extends Controller
{
    /**
     * Tampilkan daftar order untuk kurir
     */
    public function index()
    {
        $orders = Order::where('status', 'penjemputan')
            ->where('jemput_barang', 'yes')
            ->get();

        // Pastikan menggunakan view yang sesuai
        return view('kurir', compact('orders')); // Ubah dari 'kurir.index' menjadi 'kurir'
    }

    /**
     * Konfirmasi penjemputan oleh kurir
     */
    public function confirmPickup(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update([
            'status' => 'diproses' // Update status
        ]);

        return response()->json(['message' => 'Penjemputan dikonfirmasi!']);
    }

    /**
     * API untuk PWA (ambil data order)
     */
    public function apiOrders()
    {
        $orders = Order::where('status', 'penjemputan')->get();
        return response()->json($orders);
    }
}
