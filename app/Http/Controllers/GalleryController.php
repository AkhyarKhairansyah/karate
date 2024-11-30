<?php
namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Menampilkan semua gambar
    public function index()
    {
        $galleries = Gallery::all();
        return view('gallery.index', compact('galleries'));
    }

    // Menampilkan form untuk menambah gambar
    public function create()
    {
        return view('gallery.create');
    }

    // Menyimpan gambar ke database
    public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Simpan gambar di storage/public/galleries
    $path = $request->file('image')->store('public/galleries');

    // Simpan informasi gambar ke database
    Gallery::create([
        'image_path' => $path,
    ]);

    return redirect()->route('gallery.index')->with('success', 'Gambar berhasil ditambahkan.');
}


    // Menampilkan form untuk mengedit gambar
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('gallery.edit', compact('gallery'));
    }

    // Mengupdate gambar
    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gallery = Gallery::findOrFail($id);

        if ($request->hasFile('image')) {
            // Hapus gambar lama
            Storage::delete($gallery->image_path);

            // Simpan gambar baru
            $path = $request->file('image')->store('public/galleries');
            $gallery->image_path = $path;
        }

        $gallery->save();

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil diperbarui.');
    }

    // Menghapus gambar
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Hapus gambar dari storage
        Storage::delete($gallery->image_path);

        // Hapus record dari database
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Gambar berhasil dihapus.');
    }
}
