<?php


namespace App\Http\Controllers;

use App\Models\Kurir;
use App\Models\Order;
use Illuminate\Container\Attributes\DB;
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

    // public function confirmPickup(Request $request, $orderId)
    // {
    //     $order = Order::findOrFail($orderId);

    //     // Validasi bahwa order ini ditugaskan ke kurir yang login
    //     if ($order->kurir->user_id != auth()->id()) {
    //         return response()->json(['error' => 'Unauthorized'], 403);
    //     }

    //     // Update status order
    //     $order->update(['status' => 'in_progress']);

    //     // Update status kurir menjadi 'on_delivery'
    //     $order->kurir->update(['status' => 'on_delivery']);

    //     return response()->json(['message' => 'Pickup confirmed', 'order' => $order]);
    // }

    /**
     * API untuk PWA (ambil data order)
     */
    public function apiOrders()
    {
        $orders = Order::where('status', 'penjemputan')->get();
        return response()->json($orders);
    }

    // public function apiOrders(Request $request)
    // {
    //     $user = auth()->user(); // Asumsi kurir sudah login

    //     $orders = Order::whereHas('kurir', function ($query) use ($user) {
    //         $query->where('user_id', $user->id);
    //     })
    //         ->with(['user', 'damageDetails'])
    //         ->orderBy('status')
    //         ->orderBy('tgl_pesan', 'desc')
    //         ->get();

    //     return response()->json($orders);
    // }


    // app/Http/Controllers/KurirController.php
    public function getOrders(Request $request)
    {
        $search = $request->query('search');

        $orders = Order::whereHas('kurir', function ($query) {
            // $query->where('user_id', auth()->id()); // Asumsi kurir login
        })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id_random', 'like', "%$search%")
                        ->orWhere('username', 'like', "%$search%")
                        ->orWhere('barang', 'like', "%$search%");
                });
            })
            ->get();

        return response()->json($orders);
    }


    // public function updateLocation(Request $request)
    // {
    //     $request->validate([
    //         'latitude' => 'required|numeric',
    //         'longitude' => 'required|numeric'
    //     ]);

    //     $kurir = Kurir::where('user_id', auth()->id())->firstOrFail();

    //     $kurir->update([
    //         'current_location' => DB::raw("POINT({$request->longitude}, {$request->latitude})")
    //     ]);

    //     return response()->json(['message' => 'Location updated']);
    // }


    public function updateStatus($id, Request $request)
    {
        $order = Order::findOrFail($id);

        // Validasi alur status
        if ($request->status === 'in_progress' && !in_array($order->status, ['pending', 'assigned'])) {
            return response()->json(['error' => 'Invalid status transition'], 400);
        }

        $order->update(['status' => $request->status]);

        return response()->json(['message' => 'Status updated']);
    }
}
