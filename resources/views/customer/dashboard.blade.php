<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Customer') }}
        </h2>
    </x-slot>
    @section('content')
    <div class="bg-gray-100 h-fit w-full p-6">
        <div class="flex flex-col lg:flex-row pt-4 px-4 lg:px-10 pb-4">
            <div class="w-full">
                <!-- Bagian Atas -->
                <div class="flex flex-col lg:flex-row w-full">
                    <!-- Kartu Welcome -->
                    <div
                        class="bg-no-repeat bg-[#c01315] border shadow-xl rounded-xl w-full md:w-2/3 lg:mr-2 p-6 mb-4 lg:mb-0">
                        <p class="text-4xl lg:text-5xl text-white">
                            Selamat Datang, <strong>{{ Auth::user()->nama }}!</strong>
                        </p>
                        @if($penyewaan->isNotEmpty())
                        <div class="mt-8 text-white">
                            <h3 class="text-2xl mb-4 text-white font-semibold">Penyewaan Mendatang:</h3>
                            <p class="text-lg text-white font-semibold">
                                Anda memiliki penyewaan mendatang pada <strong>{{ $penyewaan->first()->tanggal_mulai }}</strong>
                                di <strong>{{ $penyewaan->first()->gedung->nama_gedung }}</strong>,
                            </p>
                        </div>
                        @else
                        <p class="mt-4 text-white text-lg font-semibold">Anda tidak memiliki penyewaan mendatang.</p>
                        @endif
                        <div class="mt-20">
                            <a href="{{ route('penyewaan.customer') }}" class="text-white text-lg font-semibold hover:underline">
                                Lihat Selengkapnya >
                            </a>
                        </div>
                    </div>

                    <!-- Kartu Inbox -->
                    <div
                        class="bg-no-repeat bg-white border border-[#c01315] shadow-xl rounded-xl w-full md:w-1/3 lg:ml-2 p-6">
                        @if($penyewaan_pending->isNotEmpty())
                        <p class="text-2xl font-semibold lg:text-5xl text-[#c01315] mb-4">
                            Penyewaan Pending!
                        </p>
                        <div class="mt-4">
                            <p class="text-lg text-[#c01315] font-semibold">
                                Anda memiliki penyewaan yang belum dikonfirmasi.
                            </p>
                        </div>
                        @else
                        <p class="text-2xl font-semibold lg:text-5xl text-[#c01315] mb-4">
                            Penyewaan Pending = 0
                        </p>
                        <p class="mt-4 text-[#c01315] text-lg font-semibold">Anda tidak memiliki penyewaan yang belum dikonfirmasi</p>
                        @endif
                        <a href="{{ route('penyewaan.customer') }}" class="bg-[#c01315] text-lg lg:text-xl text-white underline hover:no-underline inline-block rounded-full mt-10 lg:mt-12 px-6 py-2">
                            <strong>Lihat selengkapnya</strong>
                        </a>
                    </div>
                </div>

                <!-- Bagian Bawah -->
                <div class="bg-white border border-[#c01315] overflow-hidden shadow-sm sm:rounded-lg mt-4 shadow-xl">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-semibold">Daftar Gedung yang Tersedia</h3>

                        <!-- Tampilkan data gedung sebagai card -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                            @if($gedungs->isEmpty())
                            <p class="text-center text-gray-500">Belum ada gedung yang tersedia.</p>
                            @else
                            @foreach($gedungs as $gedung)
                            <div class="group transform hover:scale-105 transition-transform duration-300 ease-in-out ">
                                <div class="border rounded-lg p-4 shadow-lg bg-white hover:shadow-2xl relative hover:bg-black hover:bg-opacity-30 border border-[#c01315]">
                                    <!-- Gambar Gedung -->
                                    <img src="{{ asset('storage/' . $gedung->gambar_gedung) }}"
                                        alt="Gambar Gedung"
                                        class="w-full h-40 object-cover rounded-lg mb-4">

                                    <!-- Nama Gedung -->
                                    <h3 class="text-xl font-bold text-gray-800 mt-2">{{ $gedung->nama_gedung }}</h3>

                                    <!-- Alamat dan Kapasitas -->
                                    <div class="flex justify-between text-sm mt-1">
                                        <p class="text-gray-600">{{ $gedung->alamat }}</p>
                                        <p class="text-black font-semibold">Kapasitas: {{ $gedung->kapasitas }} orang</p>
                                    </div>

                                    <!-- Fasilitas -->
                                    <div class="my-4 flex justify-between text-sm">
                                        <p class="text-white bg-[#c01315] px-2 py-1 rounded-md font-semibold">Fasilitas</p>
                                        <p class="text-[#c01315] font-semibold">{{ $gedung->fasilitas }}</p>
                                    </div>

                                    <!-- Harga -->
                                    <p class="text-lg font-semibold text-black mt-2">
                                        Rp {{ number_format($gedung->harga_internal, 0, ',', '.') }}/Hari
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>

                        <!-- Link ke Halaman Detail Gedung -->
                        <div class="mt-6 text-center">
                            <a href="{{ route('customer.gedung') }}"
                                class="text-[#c01315] text-lg font-semibold hover:underline">
                                Lihat Semua Gedung yang Tersedia
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endsection
</x-app-layout>