<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\VerificationController;


class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:1|confirmed',
        ]);

        // Membuat pengguna baru
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Membuat instance VerificationController
        $verificationController = new VerificationController();

        // Kirim kode verifikasi
        $verificationController->sendVerificationCode(new Request(['email' => $user->email]));

        // Arahkan ke halaman verifikasi email, bukan login
        return redirect()->route('verify.form')->with('status', 'Akun berhasil dibuat. Silakan verifikasi email Anda.');
    }



}
