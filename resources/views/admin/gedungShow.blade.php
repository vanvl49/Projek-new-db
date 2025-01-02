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
                        <div class="">
                            <img src="{{ asset('storage/' . $gedung->gambar_gedung) }}" alt="Gambar Gedung" class="w-full h-80 object-cover rounded-lg mb-4">
                        </div>

                        <!-- Informasi Detail Gedung -->
                        <div class="ml-8">
                            <h3 class="text-4xl font-extrabold">{{ $gedung->nama_gedung }}</h3>
                            <p class="text-lg text-black font-semibold mt-2">{{ $gedung->deskripsi }}</p>

                            <!-- Alamat -->
                            <div class="flex items-center mt-4">
                                <img src="https://cdn.iconscout.com/icon/free/png-256/free-location-icon-download-in-svg-png-gif-file-formats--marker-pointer-map-pin-navigation-finance-and-economy-pack-business-icons-2561454.png?f=webp&w=256" alt="Ikon Alamat" class="w-6 h-6 mr-2">
                                <p class="text-md text-black font-semibold"><span class="font-medium">{{ $gedung->alamat }}</span></p>
                            </div>

                            <!-- Kapasitas -->
                            <div class="flex items-center mt-4">
                                <img src="https://static.vecteezy.com/system/resources/previews/008/506/404/non_2x/contact-person-red-icon-free-png.png" alt="Ikon Kapasitas" class="w-6 h-6 mr-2">
                                <p class="text-md text-black font-semibold">Kapasitas: <span class="font-medium">{{ $gedung->kapasitas }} orang</span></p>
                            </div>

                            <!-- Fasilitas -->
                            <div class="flex items-center mt-4">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTZlEusYFLcrIX0YctCHkiO-X_yF2Evf0IK7A&s" alt="Ikon Fasilitas" class="w-6 h-6 mr-2">
                                <p class="text-md text-black font-semibold">Fasilitas: <span class="font-medium">{{ $gedung->fasilitas }}</span></p>
                            </div>

                            <!-- Harga -->
                            <div class="flex items-center mt-4">
                                <p class="text-xl text-green-600 font-semibold">Tarif Internal: <span class="font-medium">Rp {{ $gedung->harga_internal }}/Hari</span></p>
                            </div>
                            <div class="flex items-center mt-4">
                                <p class="text-xl text-[#c01315] font-semibold">Tarif Eksternal: <span class="font-medium">Rp {{ $gedung->harga_eksternal }}/Hari</span></p>
                            </div>

                            <!-- Tombol Sewa Gedung -->
                            <div class="mt-4 text-center">
                                <a href="{{ route('gedungs.edit', $gedung->id) }}"
                                    class="text-white bg-[#c01315] px-4 py-2 rounded transition-colors">
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