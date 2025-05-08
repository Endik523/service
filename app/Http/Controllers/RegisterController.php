<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Enums\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menampilkan form registrasi
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Memproses pendaftaran pengguna baru
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // 1. Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Buat user baru dengan role default 'user'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => Role::USER, // Menggunakan enum Role yang sudah Anda definisikan
        ]);

        // // 3. Login user setelah registrasi
        // Auth::login($user);

        // // 4. Redirect ke halaman sesuai role
        // return $this->redirectBasedOnRole($user);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * Redirect pengguna berdasarkan role mereka
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBasedOnRole(User $user)
    {
        switch ($user->role) {
            case Role::ADMIN:
                return redirect()->route('admin.dashboard')->with('success', 'Registrasi admin berhasil!');
            case Role::KURIR:
                return redirect()->route('kurir.dashboard')->with('success', 'Registrasi kurir berhasil!');
            default:
                return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
        }
    }
}
