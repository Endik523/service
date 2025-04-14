<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminController extends Controller
{
    // Tampilkan form
    public function form()
    {
        return view('admin.form');
    }

    // Simpan data dari form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'barang' => 'required|string|max:50',
            'alamat' => 'required|string',
            'tgl_pesan' => 'required|date',
            'pesan' => 'nullable|string',
        ]);

        $order = Order::create($validated);

        // Respons untuk Ajax request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('status.page', ['id' => $order->id])
            ]);
        }

        // Respons untuk form submission biasa
        return redirect()->route('status.page', ['id' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    // Tampilkan halaman status pesanan
    public function status($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.status', compact('order'));
    }
}
