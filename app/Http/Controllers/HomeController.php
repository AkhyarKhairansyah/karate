<?php

namespace App\Http\Controllers;

use App\Models\InfoKarate; // Pastikan model Karate diimport
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua data karate dari database
        $karates = InfoKarate::all();

        // Kirim data ke view
        return view('home.index', compact('karates'));
    }
}
