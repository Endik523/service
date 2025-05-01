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
                'no_telp' => 'required|string|max:20',
                'pesan' => 'nullable|string',
                // 'damagePhotos.*' => 'nullable|image|max:2048'
            ];

            // Handle file upload
            $photoPaths = [];
            if ($request->hasFile('damagePhotos')) {
                foreach ($request->file('damagePhotos') as $photo) {
                    $path = $photo->store('damage_photos', 'public');
                    $photoPaths[] = $path;
                }
            }

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

            // Generate id_random unik
            $validated['id_random'] = $this->generateUniqueRandomId();

            // Ambil user_id dari pengguna yang sedang login
            $userId = Auth::id();
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

    // Fungsi untuk menghasilkan id_random yang unik (3 huruf + 4 angka)
    private function generateUniqueRandomId()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numbers = '0123456789';

        do {
            // Generate 3 random letters
            $letters = '';
            for ($i = 0; $i < 3; $i++) {
                $letters .= $characters[rand(0, strlen($characters) - 1)];
            }

            // Generate 4 random numbers
            $numbersPart = '';
            for ($i = 0; $i < 4; $i++) {
                $numbersPart .= $numbers[rand(0, strlen($numbers) - 1)];
            }

            $idRandom = $letters . $numbersPart;

            // Periksa apakah id_random sudah ada di database
            $existingOrder = Order::where('id_random', $idRandom)->first();
        } while ($existingOrder); // Jika ada duplikasi, coba lagi

        return $idRandom;
    }

    // Tampilkan halaman status pesanan
    public function status($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.isi', compact('order'));
    }
}
