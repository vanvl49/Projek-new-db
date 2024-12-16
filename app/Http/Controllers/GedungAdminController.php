<?php

namespace App\Http\Controllers;

use App\Models\Gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GedungAdminController extends Controller
{
    // Menampilkan semua gedung
    public function index()
    {
        $gedungs = Gedung::all();
        $user_type = Auth::check() && Auth::user()->type ? Auth::user()->type : 'internal';

        return view('admin.gedungIndex', compact('gedungs', 'user_type'));
    }

    // Menampilkan detail gedung berdasarkan ID
    public function show($id)
    {
        $gedung = Gedung::withTrashed()->findOrFail($id);
        return view('admin.gedungShow', compact('gedung'));
    }

    // Menampilkan form tambah gedung
    public function create()
    {
        return view('admin.gedungCreate');
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

        // Simpan gambar ke dalam folder storage
        // $gambarPath = $request->file('gambar_gedung')->store('public/images');
        $gedung = new Gedung();

        if ($request->hasFile('gambar_gedung')) {
            // Simpan file gambar di folder 'public/images'
            $gambarPath = $request->file('gambar_gedung')->store('images', 'public');
            $gedung->gambar_gedung = $gambarPath;
        }

        // Simpan data gedung ke database
        $gedung->fill($request->except('gambar_gedung'));
        $gedung->save();
        // Simpan data ke database
        // Gedung::create([
        //     'nama_gedung' => $request->nama_gedung,
        //     'deskripsi' => $request->deskripsi,
        //     'kapasitas' => $request->kapasitas,
        //     'fasilitas' => $request->fasilitas,
        //     'alamat' => $request->alamat,
        //     'harga_internal' => $request->harga_internal,
        //     'harga_eksternal' => $request->harga_eksternal,
        //     'is_available' => $request->has('is_available'),
        //     'gambar_gedung' => basename($gambarPath),
        // ]);

        return redirect()->route('gedung.index')->with('success', 'Gedung berhasil ditambahkan');
    }

    public function edit($id)
    {
        $gedung = Gedung::findOrFail($id);
        return view('admin.gedungEdit', compact('gedung'));
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

    public function destroy(Request $request)
    {
        // Validasi bahwa id gedung ada dalam request
        $request->validate([
            'id' => 'required|exists:gedung,id',
        ]);

        // Mencari gedung berdasarkan ID yang diberikan
        $gedung = Gedung::findOrFail($request->id);

        // Melakukan soft delete (mengisi kolom deleted_at)
        $gedung->delete();

        // Mengarahkan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('gedung.index')->with('status', 'Gedung berhasil dihapus.');
    }
}
