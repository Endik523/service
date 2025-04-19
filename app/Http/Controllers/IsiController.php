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
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Jika belum login, kembalikan respons JSON dengan status 401
            return response()->json([
                'success' => false,
                'message' => 'User tidak login'
            ], 401);
        }

        try {
            // Ubah validasi untuk alamat berdasarkan nilai jemput_barang
            $validationRules = [
                'username' => 'required|string|max:100',
                'barang' => 'required|string|max:50',
                'tgl_pesan' => 'required|date',
                'jemput_barang' => 'required|string',
                'pesan' => 'nullable|string',
            ];

            // Hanya wajibkan alamat jika jemput_barang = 'yes'
            if ($request->jemput_barang === 'yes') {
                $validationRules['alamat'] = 'required|string';
            } else {
                $validationRules['alamat'] = 'nullable|string';

                // Pastikan ada nilai default untuk alamat jika kosong
                if (empty($request->alamat)) {
                    $request->merge(['alamat' => '-']);
                }
            }

            $validated = $request->validate($validationRules);

            // // Fungsi untuk menghasilkan random_id unik
            // $randomId = $this->generateUniqueRandomId();

            // Ambil user_id dari pengguna yang sedang login
            $userId = Auth::id();

            // Simpan data pesanan dengan random_id yang unik dan user_id yang terkait
            // $validated['random_id'] = $randomId;
            $validated['user_id'] = $userId;

            // Simpan order
            $order = Order::create($validated);

            // Mengembalikan respons JSON yang valid
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'data' => $order
            ]);
        } catch (\Exception $e) {
            // Tangkap error dan kembalikan JSON error
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    // // Fungsi untuk menghasilkan random_id yang unik
    // private function generateUniqueRandomId()
    // {
    //     do {
    //         // Menghasilkan random_id 4 digit
    //         $randomId = rand(1000, 9999);

    //         // Periksa apakah random_id sudah ada di database
    //         $existingOrder = Order::where('random_id', $randomId)->first();
    //     } while ($existingOrder); // Jika ada duplikasi, coba lagi

    //     return $randomId;
    // }


    // Tampilkan halaman status pesanan
    public function status($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.isi', compact('order'));
    }
}
