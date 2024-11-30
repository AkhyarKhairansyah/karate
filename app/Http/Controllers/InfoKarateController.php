<?php

namespace App\Http\Controllers;

use App\Models\InfoKarate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfoKarateController extends Controller
{
    public function index()
    {
        $karates = InfoKarate::all();
        return view('info_karate.index', compact('karates'));
    }

    public function create()
    {
        return view('info_karate.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'required|date',
        'place' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi gambar
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('karate_images', 'public'); // Simpan gambar
        $validated['image'] = $imagePath; // Tambahkan path gambar ke data yang akan disimpan
    }

    InfoKarate::create($validated);

    return redirect()->route('home.index')->with('success', 'Info Karate berhasil ditambahkan.');
}


    public function edit(InfoKarate $karate)
    {
        return view('info_karate.edit', compact('karate'));
    }

    public function update(Request $request, InfoKarate $karate)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'date' => 'required|date',
        'place' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Hapus gambar lama jika ada
        if ($karate->image && Storage::disk('public')->exists($karate->image)) {
            Storage::disk('public')->delete($karate->image);
        }

        $imagePath = $request->file('image')->store('karate_images', 'public');
        $validated['image'] = $imagePath;
    }

    $karate->update($validated);

    return redirect()->route('home.index')->with('success', 'Info Karate berhasil diupdate.');
}


    public function destroy(InfoKarate $karate)
    {
        $karate->delete();
        return redirect()->route('home.index')->with('success', 'Info Karate berhasil dihapus.');
    }
}
