<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    // public function login(Request $request)
    // {
    //     $validated = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     // Mencoba untuk melakukan login menggunakan email dan password
    //     if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], $request->remember)) {
    //         return redirect()->intended('/');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ]);
    // }


    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $request->session()->regenerate();

            // Redirect ke route dashboard yang sudah didefinisikan
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak cocok.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
