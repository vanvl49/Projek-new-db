@extends('layouts.app')

@section('content')
<div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                     <div class="p-6 text-gray-900">
                            @if(session('success'))
                            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                                   {{ session('success') }}
                            </div>
                            @endif
                            @if ($errors->any())
                            <div class="bg-red-100 text-red-700 p-4 mb-4">
                                   <ul>
                                          @foreach ($errors->all() as $error)
                                          <li>{{ $error }}</li>
                                          @endforeach
                                   </ul>
                            </div>
                            @endif
                            <form action="{{ route('gedungs.update', $gedung->id) }}" method="POST" enctype="multipart/form-data">
                                   @csrf
                                   @method('PUT')

                                   <label for="nama_gedung" class="block mb-2">Nama Gedung:</label>
                                   <input type="text" id="nama_gedung" name="nama_gedung"
                                          value="{{ old('nama_gedung', $gedung->nama_gedung) }}"
                                          class="w-full p-2 border rounded mb-4" required>

                                   <label for="deskripsi" class="block mb-2">Deskripsi:</label>
                                   <textarea id="deskripsi" name="deskripsi"
                                          class="w-full p-2 border rounded mb-4" required>{{ old('deskripsi', $gedung->deskripsi) }}</textarea>

                                   <label for="kapasitas" class="block mb-2">Kapasitas:</label>
                                   <input type="number" id="kapasitas" name="kapasitas"
                                          value="{{ old('kapasitas', $gedung->kapasitas) }}"
                                          class="w-full p-2 border rounded mb-4" required>

                                   <label for="fasilitas" class="block mb-2">Fasilitas:</label>
                                   <input type="text" id="fasilitas" name="fasilitas"
                                          value="{{ old('fasilitas', $gedung->fasilitas) }}"
                                          class="w-full p-2 border rounded mb-4" required>

                                   <label for="alamat" class="block mb-2">Alamat:</label>
                                   <input type="text" id="alamat" name="alamat"
                                          value="{{ old('alamat', $gedung->alamat) }}"
                                          class="w-full p-2 border rounded mb-4" required>

                                   <label for="harga_internal" class="block mb-2">Harga Internal:</label>
                                   <input type="number" step="0.01" id="harga_internal" name="harga_internal"
                                          value="{{ old('harga_internal', $gedung->harga_internal) }}"
                                          class="w-full p-2 border rounded mb-4" required>

                                   <label for="harga_eksternal" class="block mb-2">Harga Eksternal:</label>
                                   <input type="number" step="0.01" id="harga_eksternal" name="harga_eksternal"
                                          value="{{ old('harga_eksternal', $gedung->harga_eksternal) }}"
                                          class="w-full p-2 border rounded mb-4" required>

                                   <label for="is_available" class="block mb-2">Tersedia:</label>
                                   <select id="is_available" name="is_available" class="w-full p-2 border rounded mb-4" required>
                                          <option value="1" {{ $gedung->is_available ? 'selected' : '' }}>Ya</option>
                                          <option value="0" {{ !$gedung->is_available ? 'selected' : '' }}>Tidak</option>
                                   </select>

                                   <label for="gambar_gedung" class="block mb-2">Gambar Gedung:</label>
                                   <input type="file" id="gambar_gedung" name="gambar_gedung" class="w-full p-2 border rounded mb-4"
                                          required>

                                   <div class="flex justify-center mt-6">
                                          <button type="submit" class="bg-[#c01315] text-white px-4 py-2 rounded transition-colors w-60">
                                                 Simpan Perubahan
                                          </button>
                                   </div>
                            </form>
                     </div>
              </div>
       </div>
</div>
@endsection