@extends('layouts.app')

@section('title','Details Gedung')

@section('content')
@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded mb-4">
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
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Detail Gedung -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <!-- Gambar Gedung -->
                    <div>
                        <img src="#" alt="Gambar Gedung" class="w-full h-80 object-cover rounded-lg mb-4">
                    </div>

                    <!-- Informasi Detail Gedung -->
                    <div>
                        <h3 class="text-2xl font-semibold">{{ $gedung->nama_gedung }}</h3>
                        <p class="text-gray-600 mt-4">{{ $gedung->deskripsi }}</p>
                        <p class="text-sm text-gray-500 mt-4">Kapasitas: {{ $gedung->kapasitas }} orang</p>
                        <p class="text-sm text-gray-500">Fasilitas: {{ $gedung->fasilitas }}</p>
                        <p class="text-sm text-gray-500">Alamat: {{ $gedung->alamat }}</p>
                        <p class="text-sm text-gray-500">Harga Sewa Perhari: Rp {{ number_format($gedung->harga_tampil, 0, ',', '.') }}</p>

                        <div class="mt-4 text-center">
                            <button onclick="openCreatePenyewaan()" class="inline-flex text-white bg-[#c01315] border-0 py-2 px-10 focus:outline-none rounded text-lg">
                                Sewa Gedung
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="createPenyewaan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full h-fit text-center relative">
        <!-- Close Button -->
        <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800" onclick="closeCreatePenyewaan()">
            close
        </button>

        <h1 class="text-2xl font-semibold mb-4">Tambah Penyewaan</h1>
        <form action="{{ route('penyewaan.store') }}" method="POST">
            @csrf

            <input type="hidden" name="gedung_id" value="{{ $gedung->id }}">

            <label for="detail_acara" class="block mb-2">Detail Acara:</label>
            <textarea id="detail_acara" name="detail_acara" class="w-full p-2 border rounded mb-4" required></textarea>

            <!-- Input Tanggal Mulai -->
            <input type="text" id="tanggal_mulai" placeholder="Pilih Tanggal Mulai">
            <input type="text" id="tanggal_selesai" placeholder="Pilih Tanggal Selesai">


            <p class="mt-2 text-sm text-gray-600">Tanggal yang tidak tersedia akan dinonaktifkan.</p>
            <div id="message" class="mt-4 text-red-500 hidden"></div>

            <p id="hargaSewa" class="text-sm text-gray-500">Harga Sewa Perhari: Rp {{ number_format($gedung->harga_tampil, 0, ',', '.') }}</p>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Penyewaan</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    function openCreatePenyewaan() {
        document.getElementById('createPenyewaan').classList.remove('hidden');
    }

    function closeCreatePenyewaan() {
        document.getElementById('createPenyewaan').classList.add('hidden');
    }

    const hargaPerHari = parseInt("{{ $gedung->harga_tampil }}", 10); // Ambil harga per hari dari backend

    function hitungHargaSewa() {
        const tanggalMulai = document.getElementById('tanggal_mulai').value;
        const tanggalSelesai = document.getElementById('tanggal_selesai').value;

        if (tanggalMulai && tanggalSelesai) {
            const mulai = new Date(tanggalMulai);
            const selesai = new Date(tanggalSelesai);

            // Hitung durasi dalam hari
            const durasi = (selesai - mulai) / (1000 * 60 * 60 * 24) + 1;

            if (durasi > 0) {
                const totalHarga = durasi * hargaPerHari;
                document.getElementById('hargaSewa').textContent =
                    `Harga Sewa: Rp. ${totalHarga.toLocaleString('id-ID')}`;
            } else {
                document.getElementById('hargaSewa').textContent =
                    'Tanggal selesai harus setelah tanggal mulai.';
            }
        }
    }

    // Event listener untuk update harga otomatis
    document.getElementById('tanggal_mulai').addEventListener('change', hitungHargaSewa);
    document.getElementById('tanggal_selesai').addEventListener('change', hitungHargaSewa);

    document.addEventListener('DOMContentLoaded', function() {
        const gedungId = "{{$gedung->id}}"; // ID Gedung
        fetch(`/gedung/${gedungId}/jadwal-sewa`)
            .then(response => response.json())
            .then(unavailableDates => {
                flatpickr("#tanggal_mulai", {
                    dateFormat: "Y-m-d",
                    disable: unavailableDates,
                    minDate: "today",
                });

                flatpickr("#tanggal_selesai", {
                    dateFormat: "Y-m-d",
                    disable: unavailableDates,
                    minDate: "today",
                });
            })
            .catch(error => console.error('Error fetching unavailable dates:', error));
    });
</script>