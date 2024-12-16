<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GedungController extends Controller
{
    // Menampilkan semua gedung
    public function index(Request $request)
    {
        $query = Gedung::query();

        if ($request->filled('kapasitas')) {
            $query->where('kapasitas', '>=', $request->kapasitas);
        }

        if ($request->has('nama_gedung') && $request->nama_gedung != '') {
            $query->where('nama_gedung', 'like', '%' . $request->nama_gedung . '%');
        }

        $query->where('is_available', '=', true);

        $gedungs = $query->get();

        // Logika harga berdasarkan user type
        foreach ($gedungs as $gedung) {
            $gedung->harga_tampil = Auth::user()->user_type === 'internal'
                ? $gedung->harga_internal
                : $gedung->harga_eksternal;
        }

        return view('customer.daftarGedung', compact('gedungs'));
    }


    // Menampilkan detail gedung berdasarkan ID
    public function show($id)
    {
        $gedung = Gedung::findOrFail($id);
        $gedung->harga_tampil = Auth::user()->user_type === 'internal'
            ? $gedung->harga_internal
            : $gedung->harga_eksternal;
        return view('customer.showGedung', compact('gedung'));
    }

    // Menampilkan form tambah gedung
    public function create()
    {
        return view('gedungs.create');
    }

    // Menyimpan data gedung ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kapasitas' => 'required|integer',
            'fasilitas' => 'required|string',
            'alamat' => 'required|string',
            'harga_internal' => 'required|numeric',
            'harga_eksternal' => 'required|numeric',
            'gambar_gedung' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
        ]);

        $imagePath = $request->file('gambar_gedung')->store('images/gedung', 'public');

        Gedung::create([
            'nama_gedung' => $request->nama_gedung,
            'deskripsi' => $request->deskripsi,
            'kapasitas' => $request->kapasitas,
            'fasilitas' => $request->fasilitas,
            'alamat' => $request->alamat,
            'harga_internal' => $request->harga_internal,
            'harga_eksternal' => $request->harga_eksternal,
            'is_available' => $request->has('is_available'),
            'gambar_gedung' => basename($imagePath),
        ]);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $gedung = Gedung::findOrFail($id);
        return view('gedungs.edit', compact('gedung'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_gedung' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kapasitas' => 'required|integer',
            'fasilitas' => 'required|string',
            'alamat' => 'required|string',
            'harga_internal' => 'required|numeric',
            'harga_eksternal' => 'required|numeric',
            'is_available' => 'required|boolean',
            'gambar_gedung' => 'nullable|image|max:2048',
        ]);

        $gedung = Gedung::findOrFail($id);

        // Handle file upload
        if ($request->hasFile('gambar_gedung')) {
            $gambarPath = $request->file('gambar_gedung')->store('images', 'public');
            $gedung->gambar_gedung = $gambarPath;
        }

        $gedung->update($request->except('gambar_gedung') + ['gambar_gedung' => $gedung->gambar_gedung]);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil diperbarui.');
    }
}
