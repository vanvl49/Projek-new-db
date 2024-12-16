@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Edit Gedung</h1>
    <form action="{{ route('gedungs.update', $gedung->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="nama_gedung" class="block mt-4">Nama Gedung:</label>
        <input type="text" id="nama_gedung" name="nama_gedung" 
               value="{{ old('nama_gedung', $gedung->nama_gedung) }}" 
               class="w-full border rounded p-2" required>

        <label for="deskripsi" class="block mt-4">Deskripsi:</label>
        <textarea id="deskripsi" name="deskripsi" 
                  class="w-full border rounded p-2" required>{{ old('deskripsi', $gedung->deskripsi) }}</textarea>

        <label for="kapasitas" class="block mt-4">Kapasitas:</label>
        <input type="number" id="kapasitas" name="kapasitas" 
               value="{{ old('kapasitas', $gedung->kapasitas) }}" 
               class="w-full border rounded p-2" required>

        <label for="fasilitas" class="block mt-4">Fasilitas:</label>
        <input type="text" id="fasilitas" name="fasilitas" 
               value="{{ old('fasilitas', $gedung->fasilitas) }}" 
               class="w-full border rounded p-2" required>

        <label for="alamat" class="block mt-4">Alamat:</label>
        <input type="text" id="alamat" name="alamat" 
               value="{{ old('alamat', $gedung->alamat) }}" 
               class="w-full border rounded p-2" required>

        <label for="harga_internal" class="block mt-4">Harga Internal:</label>
        <input type="number" step="0.01" id="harga_internal" name="harga_internal" 
               value="{{ old('harga_internal', $gedung->harga_internal) }}" 
               class="w-full border rounded p-2" required>

        <label for="harga_eksternal" class="block mt-4">Harga Eksternal:</label>
        <input type="number" step="0.01" id="harga_eksternal" name="harga_eksternal" 
               value="{{ old('harga_eksternal', $gedung->harga_eksternal) }}" 
               class="w-full border rounded p-2" required>

        <label for="is_available" class="block mt-4">Tersedia:</label>
        <select id="is_available" name="is_available" class="w-full border rounded p-2" required>
            <option value="1" {{ $gedung->is_available ? 'selected' : '' }}>Ya</option>
            <option value="0" {{ !$gedung->is_available ? 'selected' : '' }}>Tidak</option>
        </select>

        <label for="gambar_gedung" class="block mt-4">Gambar Gedung:</label>
        <input type="file" id="gambar_gedung" name="gambar_gedung" 
               class="w-full border rounded p-2">

        <button type="submit" class="mt-6 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
