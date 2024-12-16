<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Gedung') }}
        </h2>
    </x-slot>
@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Detail Gedung -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Gambar Gedung -->
                        <div>
                            <img src="{{ asset('storage/' . $gedung->gambar_gedung) }}" alt="Gambar Gedung" class="w-full h-80 object-cover rounded-lg mb-4">
                        </div>

                        <!-- Informasi Detail Gedung -->
                        <div>
                            <h3 class="text-2xl font-semibold">{{ $gedung->nama_gedung }}</h3>
                            <p class="text-gray-600 mt-4">{{ $gedung->deskripsi }}</p>
                            <p class="text-sm text-gray-500 mt-4">Kapasitas: {{ $gedung->kapasitas }} orang</p>
                            <p class="text-sm text-gray-500">Fasilitas: {{ $gedung->fasilitas }}</p>
                            <p class="text-sm text-gray-500">Alamat: {{ $gedung->alamat }}</p>
                            <p class="text-sm text-gray-500">Harga Internal: Rp {{ number_format($gedung->harga_internal, 0, ',', '.') }}</p>
                            <p class="text-sm text-gray-500">Harga Eksternal: Rp {{ number_format($gedung->harga_eksternal, 0, ',', '.') }}</p>

                            <div class="mt-4 text-center">
                                {{-- <a href="{{'#'}}" class="text-white bg-blue-500 px-4 py-2 rounded-full hover:bg-blue-600 transition-colors">Sewa Gedung</a> --}}

                                <a href="{{ route('gedungs.edit', $gedung->id) }}" 
                                    class="text-white bg-green-500 px-4 py-2 rounded-full hover:bg-green-600 transition-colors">
                                    Edit Gedung
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
