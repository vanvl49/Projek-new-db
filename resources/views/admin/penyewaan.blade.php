<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Penyewaan Pending') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-6">Daftar Penyewaan Pending</h3>

                    @if(session('success'))
                        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Gedung</th>
                                <th class="px-4 py-2 border">Nama Penyewa</th>
                                <th class="px-4 py-2 border">Tanggal Sewa</th>
                                <th class="px-4 py-2 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penyewaan as $index => $item)
                                <tr>
                                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $item->gedung->nama_gedung }}</td>
                                    <td class="px-4 py-2 border">{{ $item->user->nama }}</td>
                                    <td class="px-4 py-2 border">
                                       Dari: {{ $item->tanggal_mulai }} -- {{ $item->tanggal_selesai }}
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        <button class="bg-green-500 text-white px-4 py-2 rounded-md konfirmasi-btn"
                                            data-id="{{ $item->id }}" data-status="confirmed">
                                            Konfirmasi
                                        </button>
                                        <button class="bg-red-500 text-white px-4 py-2 rounded-md reject-btn"
                                            data-id="{{ $item->id }}" data-status="rejected">
                                            Tolak
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">
                                        Tidak ada data penyewaan yang pending.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirmModal" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg w-96">
            <h3 class="text-xl font-semibold mb-4">Apakah Anda yakin?</h3>
            <p class="mb-4">Apakah Anda yakin ingin mengonfirmasi atau menolak penyewaan ini?</p>
            <div class="flex justify-between">
                <button id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded-md">Batal</button>
                <button id="confirmAction" class="bg-green-500 text-white px-4 py-2 rounded-md">Konfirmasi</button>
                <button id="rejectAction" class="bg-red-500 text-white px-4 py-2 rounded-md">Tolak</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            var selectedPenyewaanId; // Variabel untuk menyimpan ID penyewaan yang dipilih

            // Tampilkan modal konfirmasi ketika tombol konfirmasi atau penolakan ditekan
            $('.konfirmasi-btn, .reject-btn').on('click', function() {
                selectedPenyewaanId = $(this).data('id'); // Simpan ID penyewaan yang dipilih
                var status = $(this).data('status');
                
                // Menampilkan modal konfirmasi
                $('#confirmModal').removeClass('hidden');
                
                // Tentukan aksi berdasarkan tombol yang ditekan
                if (status == 'confirmed') {
                    $('#confirmAction').show();
                    $('#rejectAction').hide();
                } else {
                    $('#confirmAction').hide();
                    $('#rejectAction').show();
                }
            });

            // Menangani aksi Konfirmasi
            $('#confirmAction').on('click', function() {
                updateStatus('confirmed');
                $('#confirmModal').addClass('hidden'); // Tutup modal setelah aksi
            });

            // Menangani aksi Tolak
            $('#rejectAction').on('click', function() {
                updateStatus('rejected');
                $('#confirmModal').addClass('hidden'); // Tutup modal setelah aksi
            });

            // Menutup modal jika tombol Batal diklik
            $('#closeModal').on('click', function() {
                $('#confirmModal').addClass('hidden');
            });

            // Fungsi untuk memperbarui status penyewaan
            function updateStatus(status) {
                var _token = '{{ csrf_token() }}';

                $.ajax({
                    url: "{!! route('penyewaan.updateStatus') !!}",
                    method: 'POST',
                    data: {
                        _token: _token,
                        id: selectedPenyewaanId,
                        status: status
                    },
                    success: function(response) {
                        alert(response.success);
                        location.reload(); // Reload halaman setelah status berhasil diubah
                    }
                });
            }
        });
    </script>


    @endsection

</x-app-layout>