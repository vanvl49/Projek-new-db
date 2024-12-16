<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penyewaan') }}
        </h2>
    </x-slot>

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
                    <h3 class="text-xl font-semibold mb-6">Daftar Penyewaan Mendatang</h3>
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Gedung</th>
                                <th class="px-4 py-2 border">Detail Acara</th>
                                <th class="px-4 py-2 border">Tanggal Sewa</th>
                                <th class="px-4 py-2 border">Total Harga</th> <!-- Kolom Baru -->
                                <th class="px-4 py-2 border">Status Konfirmasi</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($penyewaan_confirmed as $index => $item)
                            @php
                            // Hitung durasi penyewaan dalam hari
                            $tanggalMulai = new DateTime($item->tanggal_mulai);
                            $tanggalSelesai = new DateTime($item->tanggal_selesai);
                            $durasi = $tanggalSelesai->diff($tanggalMulai)->days + 1;

                            $userType = auth()->user()->user_type; // Make sure the field is correctly named in your database
                            $isInternal = ($userType === 'internal');

                            $hargaPerHari = $isInternal ? $item->gedung->harga_internal : $item->gedung->harga_eksternal;

                            // Calculate total price
                            $totalHarga = $durasi * $hargaPerHari;
                            @endphp
                            <tr>
                                <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $item->gedung->nama_gedung }}</td>
                                <td class="px-4 py-2 border">{{ $item->detail_acara }}</td>
                                <td class="px-4 py-2 border">
                                    Dari : {{ $item->tanggal_mulai }} -- {{ $item->tanggal_selesai }}
                                </td>
                                <td class="px-4 py-2 border text-right">
                                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @if ($item->confirmed_status === 'confirmed')
                                    <span class="text-green-600 font-semibold">Terverifikasi</span>
                                    @elseif ($item->confirmed_status === 'rejected')
                                    <span class="text-red-600 font-semibold">Dibatalkan</span>
                                    @elseif ($item->confirmed_status === 'pending')
                                    <span class="text-gray-500 font-semibold">Menunggu Konfirmasi</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <button
                                        onclick="openDeletePenyewaan('{{ $item->id }}')"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md">
                                        Batalkan
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">
                                    Tidak ada data penyewaan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <br>
                    <h3 class="text-xl font-semibold mb-6">Daftar Penyewaan Belum Terkonfirmasi mu</h3>
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Gedung</th>
                                <th class="px-4 py-2 border">Detail Acara</th>
                                <th class="px-4 py-2 border">Tanggal Sewa</th>
                                <th class="px-4 py-2 border">Total Harga</th> <!-- Kolom Baru -->
                                <th class="px-4 py-2 border">Status Konfirmasi</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($penyewaan as $index => $item)
                            @php
                            // Hitung durasi penyewaan dalam hari
                            $tanggalMulai = new DateTime($item->tanggal_mulai);
                            $tanggalSelesai = new DateTime($item->tanggal_selesai);
                            $durasi = $tanggalSelesai->diff($tanggalMulai)->days + 1;

                            $userType = auth()->user()->user_type; // Make sure the field is correctly named in your database
                            $isInternal = ($userType === 'internal');

                            $hargaPerHari = $isInternal ? $item->gedung->harga_internal : $item->gedung->harga_eksternal;

                            // Calculate total price
                            $totalHarga = $durasi * $hargaPerHari;
                            @endphp
                            <tr>
                                <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $item->gedung->nama_gedung }}</td>
                                <td class="px-4 py-2 border">{{ $item->detail_acara }}</td>
                                <td class="px-4 py-2 border">
                                    Dari : {{ $item->tanggal_mulai }} -- {{ $item->tanggal_selesai }}
                                </td>
                                <td class="px-4 py-2 border text-right">
                                    Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    @if ($item->confirmed_status === 'confirmed')
                                    <span class="text-green-600 font-semibold">Terverifikasi</span>
                                    @elseif ($item->confirmed_status === 'rejected')
                                    <span class="text-red-600 font-semibold">Dibatalkan</span>
                                    @elseif ($item->confirmed_status === 'pending')
                                    <span class="text-gray-500 font-semibold">Menunggu Konfirmasi</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <button onclick="openEditPenyewaan('{{ $item->id }}', '{{ $item->detail_acara }}', '{{ $item->tanggal_mulai }}', '{{ $item->tanggal_selesai }}', '{{ $item->gedung_id }}')" class="bg-green-500 text-white px-4 py-2 rounded-md">
                                        Ubah
                                    </button>

                                    <br>
                                    <button
                                        onclick="openDeletePenyewaan('{{ $item->id }}')"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md">
                                        Batalkan
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-gray-500 py-4">
                                    Tidak ada data penyewaan.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="editPenyewaan" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full h-fit text-center relative">
            <!-- Close Button -->
            <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800" onclick="closeEditPenyewaan()">
                close
            </button>

            <h1 class="text-2xl font-semibold mb-4">Ubah Penyewaan</h1>
            <form action="{{ route('penyewaan.update') }}" method="POST">
                @csrf

                <input type="hidden" name="id" id="modal-id">
                <input type="hidden" name="gedung_id" id="modal-gedung-id">

                <label for="detail_acara" class="block mb-2">Detail Acara:</label>
                <textarea id="detail_acara" name="detail_acara" class="w-full p-2 border rounded mb-4" required></textarea>

                <label for="tanggal_mulai" class="block mb-2">Tanggal Mulai:</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="w-full p-2 border rounded mb-4" required>

                <label for="tanggal_selesai" class="block mb-2">Tanggal Selesai:</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="w-full p-2 border rounded mb-4" required>

                <p id="totalPrice" class="text-lg text-gray-700 mt-4">Harga Total: Rp 0</p>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Ubah Penyewaan</button>
            </form>
        </div>
    </div>

    <!-- Pop-up Konfirmasi -->
    <div id="deletePenyewaan" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-md w-80 text-center">
            <h3 id="popup-message" class="text-lg font-semibold mb-4">Apakah Anda yakin untuk membatalkan penyewaan?</h3>
            <form id="confirm-form" action="{{ route('penyewaan.destroy') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="delete-item-id">
                <button type="submit" onclick="closeDeletePenyewaan()" class="bg-red-500 text-white px-4 py-2 rounded-md">
                    Batalkan Penyewaan
                </button>
                <button type="button" onclick="closeDeletePenyewaan()" class="bg-gray-500 text-white px-4 py-2 rounded-md">
                    Kembali
                </button>
            </form>
        </div>
    </div>

    <!-- Script for Pop-up -->
    @foreach ($penyewaan as $index => $item)
    <script>
        function openDeletePenyewaan(id) {
            document.getElementById('deletePenyewaan').classList.remove('hidden');
            document.getElementById('delete-item-id').value = id; // Updated line to set the id properly
        }


        function closeDeletePenyewaan() {
            document.getElementById('deletePenyewaan').classList.add('hidden');
        }

        function openEditPenyewaan(id, detailAcara, tanggalMulai, tanggalSelesai, gedungId) {
            document.getElementById('editPenyewaan').classList.remove('hidden');
            document.getElementById('detail_acara').value = detailAcara;
            document.getElementById('tanggal_mulai').value = tanggalMulai;
            document.getElementById('tanggal_selesai').value = tanggalSelesai;
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-gedung-id').value = gedungId;
        }



        function closeEditPenyewaan() {
            document.getElementById('editPenyewaan').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Get initial price values

            let hargaInternal = parseInt("{{ $item->gedung->harga_internal}}", 10);
            let hargaEksternal = parseInt("{{ $item->gedung->harga_eksternal}}", 10);
            let userType = "{{ auth()->user()->user_type }}"; // Determine if the user is internal or external
            let isInternal = userType === 'internal';

            // Function to update total price
            function updateTotalPrice() {
                let tanggalMulai = new Date(document.getElementById('tanggal_mulai').value);
                let tanggalSelesai = new Date(document.getElementById('tanggal_selesai').value);

                if (tanggalMulai && tanggalSelesai && tanggalSelesai >= tanggalMulai) {
                    let diffTime = tanggalSelesai - tanggalMulai;
                    let diffDays = diffTime / (1000 * 3600 * 24) + 1; // Add 1 to include both start and end day

                    // Choose the correct price based on internal or external user
                    let hargaPerHari = isInternal ? hargaInternal : hargaEksternal;

                    // Calculate total price
                    let totalHarga = diffDays * hargaPerHari;

                    // Update total price in the form
                    document.getElementById('totalPrice').innerText = `Harga Total: Rp ${totalHarga.toLocaleString()}`;
                }
            }

            // Add event listeners to recalculate total price on date change
            document.getElementById('tanggal_mulai').addEventListener('change', updateTotalPrice);
            document.getElementById('tanggal_selesai').addEventListener('change', updateTotalPrice);

            // Initialize total price when the page loads
            updateTotalPrice();
        });
    </script>
    @endforeach
    @endsection
</x-app-layout>