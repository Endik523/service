<?php

namespace App\Http\Controllers;

use App\Models\DamageDetails;
use App\Models\Kurir;
use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    // Method untuk menampilkan status menggunakan query parameter
    public function show(Request $request)
    {
        // Ambil id_order dari query parameter
        $id_order = $request->query('id_order');
        // dd($id_order);

        if (!$id_order) {
            return redirect()->route('dashboard')->with('error', 'ID order tidak ditemukan');
        }

        try {
            // Cari data order berdasarkan id_order
            $order = Order::findOrFail($id_order);

            // Ambil detail kerusakan/barang yang dipesan
            $damageDetails = DamageDetails::where('id_order', $id_order)->get();

            // Hitung total biaya
            $totalBiaya = $damageDetails->sum('harga_barang');

            // Ambil data kurir berdasarkan order_id
            $kurir = Kurir::where('order_id', $id_order)->first();
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Order tidak ditemukan');
        }

        // Kirim data ke view
        return view('status', [
            'order' => $order,
            'damageDetails' => $damageDetails,
            'totalBiaya' => $totalBiaya
        ]);
    }
}
