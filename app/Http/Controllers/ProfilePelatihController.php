<?php

namespace App\Http\Controllers;

use App\Models\ProfilePelatih;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Pest\Plugins\Profile;

class ProfilePelatihController extends Controller
{

    public function index()
    {
        return ProfilePelatih::all();
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_awal' => 'required|string|max:255',
        'nama_akhir' => 'required|string|max:255',
        'pangkat' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('foto')) {
        $fileName = time() . '.' . $request->foto->extension();
        $request->foto->move(public_path('uploads/pelatih'), $fileName);
        $data['foto'] = 'uploads/pelatih/' . $fileName;
    }

    ProfilePelatih::create($data);

    return redirect()->route('profile-pelatih.index')->with('success', 'Profile Pelatih berhasil ditambahkan.');
}



    public function show(ProfilePelatih $profilePelatih, $id)
    {
        return ProfilePelatih::findOrFail($id);
    }

    public function update(Request $request, ProfilePelatih $profilePelatih)
{
    $request->validate([
        'nama_awal' => 'required|string|max:255',
        'nama_akhir' => 'required|string|max:255',
        'pangkat' => 'required|string|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('foto')) {
        // Hapus foto lama jika ada
        if ($profilePelatih->foto && file_exists(public_path($profilePelatih->foto))) {
            unlink(public_path($profilePelatih->foto));
        }

        $fileName = time() . '.' . $request->foto->extension();
        $request->foto->move(public_path('uploads/pelatih'), $fileName);
        $data['foto'] = 'uploads/pelatih/' . $fileName;
    }

    $profilePelatih->update($data);

    return redirect()->route('profile-pelatih.index')->with('success', 'Profile Pelatih berhasil diperbarui.');
}


public function destroy(ProfilePelatih $profilePelatih)
{
    if ($profilePelatih->foto && file_exists(public_path($profilePelatih->foto))) {
        unlink(public_path($profilePelatih->foto));
    }

    $profilePelatih->delete();

    return redirect()->route('profile-pelatih.index')->with('success', 'Profile Pelatih berhasil dihapus.');
}

}
