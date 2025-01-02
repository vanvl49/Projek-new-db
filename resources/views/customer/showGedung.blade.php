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

                        <div class="flex items-center mt-4">
                            <img src="https://cdn1.iconfinder.com/data/icons/color-bold-style/21/06_1-512.png" alt="Ikon Fasilitas" class="w-6 h-6 mr-2">
                            <button class="text-md text-black font-semibold" onclick='openCalendarModal("{{ $gedung->id }}")'>Jadwal Penyewaan</button>

                        </div>

                        <!-- Harga -->
                        <div class="flex items-center mt-4">
                            <p class="text-2xl text-[#c01315] font-semibold">Tarif: <span class="font-medium">Rp {{ number_format($gedung->harga_tampil, 0, ',', '.')}}/Hari</span></p>
                        </div>

                        <!-- Tombol Sewa Gedung -->
                        <div class="mt-6 text-center">
                            <button onclick="openCreatePenyewaan()" class="inline-flex text-white bg-[#c01315] border-0 py-2 px-10 focus:outline-none rounded-xl text-lg">
                                Sewa Gedung
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Calendar Modal -->
<div id="calendarModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-4xl w-full h-[600px] text-center relative">
        <button id="closeCalendarBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800" onclick="closeCalendarModal()">X</button>
        <h1 class="text-2xl font-semibold mb-4">Jadwal Penyewaan {{ $gedung->nama_gedung }}</h1>
        <div id="calendar" class="w-full h-full"></div>
    </div>
</div>




<div id="createPenyewaan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full h-fit text-center relative">
        <!-- Close Button -->
        <button id="closeModalBtn" class="absolute top-4 right-4 text-lg text-black hover:text-[#c01315]" onclick="closeCreatePenyewaan()">
            x
        </button>

        <h1 class="text-2xl font-semibold mb-4">Tambah Penyewaan</h1>
        <form action="{{ route('penyewaan.store') }}" method="POST">
            @csrf

            <input type="hidden" name="gedung_id" value="{{ $gedung->id }}">

            <label for="detail_acara" class="block mb-2">Detail Acara:</label>
            <textarea id="detail_acara" name="detail_acara" class="w-full p-2 border rounded mb-4" required></textarea>

            <label for="tanggal_mulai" class="block mb-2">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="w-full p-2 border rounded mb-4" required>
            <label for="tanggal_selesai" class="block mb-2">Tanggal Selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="w-full p-2 border rounded mb-4" required>

            <div id="message" class="mt-4 text-red-500 hidden"></div>

            <p id="hargaSewa" class="text-md text-[#c01315]">Harga Sewa Perhari: Rp {{ number_format($gedung->harga_tampil, 0, ',', '.') }}</p>

            <button type="submit" class="mt-4 bg-[#c01315] text-white px-4 py-2 rounded">Tambah Penyewaan</button>
        </form>
    </div>
</div>

<script>
    function openCreatePenyewaan() {
        document.getElementById('createPenyewaan').classList.remove('hidden');
    }

    function closeCreatePenyewaan() {
        document.getElementById('createPenyewaan').classList.add('hidden');
    }

    function openCalendarModal(gedungId) {
        document.getElementById('calendarModal').classList.remove('hidden');
        loadCalendarData();
        calendar.render();
        calendar.updateSize();

        // // Initialize FullCalendar
        // $('#calendar').fullCalendar({
        //     events: function(start, end, timezone, callback) {
        //         $.ajax({
        //             url: `/penyewaan/${gedungId}/schedule`,
        //             dataType: 'json',
        //             success: function(data) {
        //                 callback(data);
        //             }
        //         });
        //     },
        //     header: {
        //         left: 'prev,next today',
        //         center: 'title',
        //         right: 'month,agendaWeek,agendaDay'
        //     }
        // });
    }

    function closeCalendarModal() {
        document.getElementById('calendarModal').classList.add('hidden');
        $('#calendar').fullCalendar('destroy');
    }

    function loadCalendarData() {
        const gedungId = "{{ $gedung->id }}";
        fetch(`/gedung/${gedungId}/jadwal-sewa`)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                calendar.removeAllEvents();
                calendar.addEventSource(data);
            })
            .catch(error => console.error('Error loading calendar data:', error));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const calendarModal = document.getElementById('calendarModal');
        const closeCalendarBtn = document.getElementById('closeCalendarBtn');
        const openCalendarBtn = document.querySelector('.text-black.font-semibold');

        const gedungId = "{{ $gedung->id }}";

        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            eventDisplay: 'block',
            events: function(fetchInfo, successCallback, failureCallback) {
                fetch(`/gedung/${gedungId}/jadwal-sewa`)
                    .then(response => response.json())
                    .then(data => successCallback(data))
                    .catch(error => failureCallback(error));
            }
        });

        calendar.render();

        let hargaPerHari = parseInt("{{ $gedung->harga_tampil}}", 10);

        function updateTotalPrice() {
            let tanggalMulai = new Date(document.getElementById('tanggal_mulai').value);
            let tanggalSelesai = new Date(document.getElementById('tanggal_selesai').value);

            if (tanggalMulai && tanggalSelesai && tanggalSelesai >= tanggalMulai) {
                let diffTime = tanggalSelesai - tanggalMulai;
                let diffDays = diffTime / (1000 * 3600 * 24) + 1;

                let totalHarga = diffDays * hargaPerHari;

                document.getElementById('hargaSewa').innerText = `Harga Total: Rp ${totalHarga.toLocaleString()}`;
            } else {
                document.getElementById('hargaSewa').innerText = "Harga Total: Rp 0";
            }
        }

        document.getElementById('tanggal_mulai').addEventListener('change', updateTotalPrice);
        document.getElementById('tanggal_selesai').addEventListener('change', updateTotalPrice);

        updateTotalPrice();
    });
</script>
@endsection