<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VerificationController extends Controller
{

    public function showVerificationForm()
{
    return view('auth.verify'); // Pastikan menggunakan path yang sesuai
}
    // Mengirim kode verifikasi ke email pengguna
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate kode verifikasi
        $verificationCode = Str::random(6); // Misalnya kode 6 karakter

        // Simpan kode verifikasi ke user
        $user->verification_code = $verificationCode;
        $user->save();

        // Kirim email dengan kode verifikasi
        Mail::to($user->email)->send(new VerificationEmail($verificationCode));

        // Simpan email di sesi
        session(['email_for_verification' => $user->email]);

        // Alihkan ke halaman verifikasi
        return redirect()->route('verify.form')->with('success', 'Kode verifikasi telah dikirim ke email Anda.');
    }





    // Verifikasi kode yang dimasukkan oleh pengguna
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'verification_code' => 'required|string|size:6', // Pastikan panjangnya sesuai dengan kode yang dikirim
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah kode verifikasi cocok
        if ($user->verification_code !== $request->verification_code) {
            throw ValidationException::withMessages([
                'verification_code' => 'Kode verifikasi tidak valid.',
            ]);
        }

        // Verifikasi email
        $user->email_verified_at = now();
        $user->verification_code = null; // Hapus kode verifikasi setelah sukses
        $user->save();

        // Hapus email dari sesi setelah verifikasi berhasil
        session()->forget('email_for_verification');

        // Alihkan ke halaman login setelah berhasil verifikasi
        return redirect()->route('login.form')->with('success', 'Email berhasil diverifikasi. Silakan masuk.');
    }


}
