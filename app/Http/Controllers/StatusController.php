<?php

namespace App\Http\Controllers;

use App\Models\DamageDetails;
use App\Models\Kurir;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;



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


    public function updateLocation(Request $request)
    {
        // Validasi input dari request
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'courier_id' => 'required|exists:kurirs,id',
        ]);

        // Cari kurir berdasarkan ID
        $courier = Kurir::find($request->courier_id);

        // Update lokasi kurir
        $courier->latitude = $request->latitude;
        $courier->longitude = $request->longitude;
        $courier->save();

        // Return response sukses
        return response()->json([
            'message' => 'Lokasi kurir berhasil diperbarui!',
            'data' => $courier
        ], 200);
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

    public function processPayment(Request $request)
    {
        $orderId = $request->input('order_id');

        // Validasi apakah order ID valid
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan tidak ditemukan.'
            ]);
        }

        $totalBiaya = DamageDetails::where('order_id', $orderId)
            ->sum('harga_barang');

        // Konfigurasi Midtrans
        Config::$serverKey = 'SB-Mid-server-rIrdxjEO9iNeEZPs4a3pviZB';
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Parameter transaksi
        $params = [
            'transaction_details' => [
                'order_id' => $order->id_random, // ID Pesanan Random yang ditampilkan di halaman status
                'gross_amount' => $totalBiaya, // Misalnya ada kolom total biaya di model Order
            ],
            // Anda bisa menambahkan parameter lain yang diperlukan oleh Midtrans
        ];

        // Mendapatkan token Snap Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'success' => true,
                'payment_url' => $snapToken, // Atau URL yang sesuai dengan API Midtrans
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'gagal'
            ]);
        }
    }
}
