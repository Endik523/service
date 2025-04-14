<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class IsiController extends Controller
{
    // Tampilkan form
    public function form()
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect()->route('login');
        }

        return view('admin.isi');
    }

    // Simpan data dari form
    public function store(Request $request)
    {
        // dd("uhjds");
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, arahkan ke halaman login
            return redirect()->route('login');

            // Jika belum login, kembalikan respons JSON, bukan redirect
            // return response()->json([
            //     'success' => false,
            //     'message' => 'User tidak login'
            // ], 401);
        }

        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'barang' => 'required|string|max:50',
            'alamat' => 'required|string',
            'tgl_pesan' => 'required|date',
            'pesan' => 'nullable|string',
        ]);

        // Fungsi untuk menghasilkan random_id unik
        $randomId = $this->generateUniqueRandomId();

        // Ambil user_id dari pengguna yang sedang login
        $userId = Auth::id();

        // Simpan data pesanan dengan random_id yang unik dan user_id yang terkait
        $validated['random_id'] = $randomId;
        $validated['user_id'] = $userId; // Menambahkan user_id yang diambil dari Auth

        // Simpan order
        $order = Order::create($validated);

        // Mengembalikan respons JSON
        // if ($order) {
        //     return response()->json(['success' => true]);
        // } else {
        //     return response()->json(['success' => false]);
        // }
    }


    // Fungsi untuk menghasilkan random_id yang unik
    private function generateUniqueRandomId()
    {
        do {
            // Menghasilkan random_id 4 digit
            $randomId = rand(1000, 9999);

            // Periksa apakah random_id sudah ada di database
            $existingOrder = Order::where('random_id', $randomId)->first();
        } while ($existingOrder); // Jika ada duplikasi, coba lagi

        return $randomId;
    }


    // Tampilkan halaman status pesanan
    public function status($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.isi', compact('order'));
    }
}
