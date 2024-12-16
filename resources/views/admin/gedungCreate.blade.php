<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Gedung') }}
        </h2>
    </x-slot>
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

                    <form action="{{ route('gedungs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <label for="nama_gedung" class="block mb-2">Nama Gedung:</label>
                        <input type="text" id="nama_gedung" name="nama_gedung" class="w-full p-2 border rounded mb-4" required>

                        <label for="deskripsi" class="block mb-2">Deskripsi:</label>
                        <textarea id="deskripsi" name="deskripsi" class="w-full p-2 border rounded mb-4" required></textarea>

                        <label for="kapasitas" class="block mb-2">Kapasitas:</label>
                        <input type="number" id="kapasitas" name="kapasitas" class="w-full p-2 border rounded mb-4" required>

                        <label for="fasilitas" class="block mb-2">Fasilitas:</label>
                        <input type="text" id="fasilitas" name="fasilitas" class="w-full p-2 border rounded mb-4" required>

                        <label for="alamat" class="block mb-2">Alamat:</label>
                        <input type="text" id="alamat" name="alamat" class="w-full p-2 border rounded mb-4" required>

                        <label for="harga_internal" class="block mb-2">Harga Internal:</label>
                        <input type="number" step="0.01" id="harga_internal" name="harga_internal" class="w-full p-2 border rounded mb-4" required>

                        <label for="harga_eksternal" class="block mb-2">Harga Eksternal:</label>
                        <input type="number" step="0.01" id="harga_eksternal" name="harga_eksternal" class="w-full p-2 border rounded mb-4" required>

                        <label for="is_available" class="block mb-2">Tersedia:</label>
                        <select id="is_available" name="is_available" class="w-full p-2 border rounded mb-4">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>

                        <label for="gambar_gedung" class="block mb-2">Gambar Gedung:</label>
                        <input type="file" id="gambar_gedung" name="gambar_gedung" class="w-full p-2 border rounded mb-4" required>

                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Gedung</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
