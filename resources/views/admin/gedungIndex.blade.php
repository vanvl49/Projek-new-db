<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kumpulan Gedung') }}
        </h2>
    </x-slot>

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Gedung yang Tersedia</h3>
                            <a href="{{ route('gedungs.create') }}" 
                                class="bg-[#c01315] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-600 transition-colors">
                                Tambah Gedung Baru
                            </a>
                        </div>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8 h-fit">
                            <div class="p-6 pb-1 text-gray-900">
                                <h3 class="text-xl font-semibold">Cari Gedung</h3>
                                <form action="{{ route('gedung.index') }}" method="GET" class="mb-6 mt-2">
                                    <div class="flex gap-4 items-center w-full">
                                        <!-- Input Nama Gedung -->
                                        <input
                                            type="text"
                                            name="nama_gedung"
                                            class="border rounded-lg px-4 py-3 w-full md:w-1/2 box-border"
                                            placeholder="Cari nama gedung"
                                            value="{{ request('nama_gedung') }}">
                                        <!-- Input Kapasitas -->
                                        <input
                                            type="number"
                                            name="kapasitas"
                                            class="border rounded-lg px-4 py-3 w-full md:w-1/2 box-border"
                                            placeholder="Minimal Kapasitas"
                                            value="{{ request('kapasitas') }}">

                                        <!-- Tombol Cari -->
                                        <button
                                            type="submit"
                                            class="flex justify-center items-center bg-[#c01315] rounded-lg w-16 h-auto px-4 py-3 shadow-md hover:shadow-lg transition box-border">
                                            <img
                                                src="https://static-00.iconduck.com/assets.00/search-icon-2044x2048-psdrpqwp.png"
                                                alt="Cari"
                                                class="w-6 h-6 object-contain">
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Tampilkan data gedung sebagai card -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                            @if($gedungs->isEmpty())
                                <p class="text-center text-gray-500">Belum ada gedung yang tersedia.</p>
                            @else
                                @foreach($gedungs as $gedung)
                                    <div class="group transform hover:scale-105 transition-transform duration-300 ease-in-out">
                                        <div class="border rounded-lg p-4 shadow-lg bg-white hover:shadow-2xl relative hover:bg-black hover:bg-opacity-30">
                                            <img src="{{ asset('storage/' . $gedung->gambar_gedung) }}" alt="Gambar Gedung" class="w-full h-40 object-cover rounded-t-lg mb-4">
                                            <h3 class="text-xl font-bold text-gray-800 mt-2">{{ $gedung->nama_gedung }}</h3>
                                            <div class="flex justify-between text-sm mt-1">
                                                <p class="text-gray-600">{{ $gedung->alamat }}</p>
                                                <p class="text-black font-semibold">Kapasitas: {{ $gedung->kapasitas }} orang</p>
                                            </div>
                                            <div class="my-4 flex justify-between text-sm">
                                                <p class="text-white bg-[#c01315] px-2 py-1 rounded-md font-semibold">Fasilitas</p>
                                                <p class="text-[#c01315] font-semibold">{{ $gedung->fasilitas }}</p>
                                            </div>
                        
                                            <!-- Harga Internal dan Eksternal -->
                                            <div class="mt-4">
                                                <p class="text-lg font-semibold text-black">Harga Internal:</p>
                                                <p class="text-md font-bold text-green-600">Rp {{ number_format($gedung->harga_internal, 0, ',', '.') }}/Hari</p>
                                                <p class="text-lg font-semibold text-black mt-2">Harga Eksternal:</p>
                                                <p class="text-md font-bold text-red-600">Rp {{ number_format($gedung->harga_eksternal, 0, ',', '.') }}/Hari</p>
                                            </div>
                        
                                            <!-- Tombol diletakkan di bagian bawah card -->
                                            <div class="absolute inset-x-0 bottom-2 flex justify-center space-x-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out px-4">
                                                <a href="{{ route('gedung.show', $gedung->id) }}"
                                                    class="text-white bg-blue-500 px-3 py-1.5 rounded-lg text-sm transition-colors hover:bg-blue-600">
                                                    Lihat Detail
                                                </a>
                        
                                                <!-- Form Hapus Gedung -->
                                                <form action="{{ route('gedung.delete') }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('POST')
                                                    <input type="hidden" name="id" value="{{ $gedung->id }}">
                                                    <button type="submit" class="text-white bg-red-500 px-3 py-1.5 rounded-lg text-sm transition-colors hover:bg-red-600">
                                                        Hapus Gedung
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>                                                                 
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>