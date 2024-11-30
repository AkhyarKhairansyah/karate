<?php

namespace App\Http\Controllers;

use App\Models\Dokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentasiController extends Controller
{
    public function index()
    {
        $dokumentasis = Dokumentasi::all();
        return view('dokumentasi.index', compact('dokumentasis'));
    }

    public function create()
    {
        return view('dokumentasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Simpan file ke storage
        $path = $request->file('file')->store('dokumen');

        // Simpan data ke database
        Dokumentasi::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'file_path' => $path,
        ]);

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);
        return view('dokumentasi.edit', compact('dokumentasi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $dokumentasi = Dokumentasi::findOrFail($id);
        $dokumentasi->judul = $request->judul;
        $dokumentasi->deskripsi = $request->deskripsi;

        if ($request->hasFile('file')) {
            // Hapus file lama
            Storage::delete($dokumentasi->file_path);

            // Simpan file baru
            $path = $request->file('file')->store('dokumen');
            $dokumentasi->file_path = $path;
        }

        $dokumentasi->save();

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $dokumentasi = Dokumentasi::findOrFail($id);

        // Hapus file yang ada di storage
        Storage::delete($dokumentasi->file_path);

        // Hapus data dari database
        $dokumentasi->delete();

        return redirect()->route('dokumentasi.index')->with('success', 'Dokumentasi berhasil dihapus');
    }
}
