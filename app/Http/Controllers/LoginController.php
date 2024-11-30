<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Verifikasi pengguna dan password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['error' => 'Email atau password salah.']);
        }

        // Memeriksa apakah email sudah diverifikasi
        if (!$user->email_verified_at) {
            return redirect()->back()->withErrors(['error' => 'Email belum diverifikasi.']);
        }

        // Login pengguna
        Auth::login($user);

        // Membuat token menggunakan Sanctum setelah login, meskipun ini tidak digunakan untuk autentikasi API di sini
        $token = $user->createToken('WebAppToken')->plainTextToken;

        // Anda bisa menyimpan token ini di sesi untuk referensi lebih lanjut jika diperlukan
        session(['token' => $token]);

        // Anda bisa menambahkan ini untuk memastikan token disimpan dalam sesi
        // return redirect()->route('dashboard')->with('success', 'Login berhasil!');

        return redirect()->route('dashboard.index');
    }

    public function logout()
    {
        // Menghapus token yang digunakan untuk autentikasi
        Auth::user()->tokens->each(function ($token) {
            $token->delete();
        });

        Auth::logout();

        // Mengarahkan pengguna ke halaman login setelah logout
        return redirect()->route('login.form')->with('success', 'Logout berhasil.');
    }
}
