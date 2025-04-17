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
        $id_order = $request->query('id_order');
        if (!$id_order) {
            return redirect()->route('dashboard')->with('error', 'ID order tidak ditemukan');
        }

        try {
            $order = Order::findOrFail($id_order);
            $damageDetails = DamageDetails::where('id_order', $id_order)->get();
            $totalBiaya = $damageDetails->sum('harga_barang');
            $kurir = Kurir::where('order_id', $id_order)->first();
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Order tidak ditemukan');
        }

        return view('status', [
            'order' => $order,
            'damageDetails' => $damageDetails,
            'totalBiaya' => $totalBiaya,
            'kurir' => $kurir
        ]);
    }
}
