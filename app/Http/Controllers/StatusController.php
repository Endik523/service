<?php

namespace App\Http\Controllers;

use App\Models\DamageDetails;
use App\Models\Kurir;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    // Method untuk menampilkan status menggunakan query parameter
    public function show(Request $request)
    {
        $order_id = $request->query('order_id');
        if (!$order_id) {
            return redirect()->route('dashboard')->with('error', 'ID order tidak ditemukan');
        }

        try {
            $order = Order::findOrFail($order_id);
            $damageDetails = DamageDetails::where('order_id', $order_id)->get();
            $totalBiaya = $damageDetails->sum('harga_barang');
            $kurir = Kurir::where('order_id', $order_id)->first();
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

    // Method untuk mengunduh PDF
    public function downloadPaymentReceipt($orderId)
    {
        // Ambil data order berdasarkan ID
        $order = Order::findOrFail($orderId);
        $damageDetails = DamageDetails::where('order_id', $orderId)->get();
        $totalBiaya = $damageDetails->sum('harga_barang'); // Hitung total biaya

        // Memastikan instansiasi PDF terlebih dahulu
        $pdf = FacadePdf::loadView('payment_receipt', compact('order', 'damageDetails', 'totalBiaya'));

        // Mengunduh PDF dengan nama file berdasarkan order ID
        return $pdf->download('catatan_pembayaran_' . $orderId . '.pdf');
    }
}
