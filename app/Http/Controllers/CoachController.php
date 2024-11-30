<?php

namespace App\Http\Controllers;

use App\Models\Coach;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index()
    {
        $coaches = Coach::all();
        return view('coaches.index', compact('coaches'));
    }

    public function create()
    {
        return view('coaches.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'rank' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $coach = Coach::create([
        'name' => $request->name,
        'rank' => $request->rank,
        'image' => $request->file('image') // Proses upload gambar
    ]);

    return redirect()->route('coaches.index');
}


    public function edit($id)
    {
        $coach = Coach::findOrFail($id);
        return view('coaches.edit', compact('coach'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'rank' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $coach = Coach::findOrFail($id);

        // Jika gambar diupload, simpan gambar baru
        if ($request->hasFile('image')) {
            $coach->image = $request->file('image');
        }

        $coach->update([
            'name' => $request->name,
            'rank' => $request->rank,
        ]);

        return redirect()->route('coaches.index');
    }


    public function destroy($id)
    {
        $coach = Coach::findOrFail($id);
        $coach->delete();

        return redirect()->route('coaches.index');
    }
}
