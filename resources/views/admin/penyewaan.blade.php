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
                    <h3 class="text-xl font-semibold mb-6">Daftar Penyewaan Belum Terkonfirmasi</h3>
                    <table class="min-w-full table-auto border-collapse border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">No</th>
                                <th class="px-4 py-2 border">Nama Gedung</th>
                                <th class="px-4 py-2 border">Nama Penyewa</th>
                                <th class="px-4 py-2 border">Tanggal Sewa</th>
                                <th class="px-4 py-2 border">Konfirmasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penyewaan as $index => $item)
                            <tr>
                                <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 border">{{ $item->gedung->nama_gedung }}</td>
                                <td class="px-4 py-2 border">{{ $item->user->nama }}</td>
                                <td class="px-4 py-2 border">
                                    Dari : {{ $item->tanggal_mulai }} -- {{ $item->tanggal_selesai }}
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <button onclick="showConfirmPopup('{{ $item->id }}', 'confirmed')"
                                        class="bg-green-500 text-white px-4 py-2 rounded-md">
                                        Konfirmasi
                                    </button>
                                    <button onclick="showConfirmPopup('{{ $item->id }}', 'rejected')"
                                        class="bg-red-500 text-white px-4 py-2 rounded-md">
                                        Reject
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

    <!-- Pop-up Konfirmasi -->
    <div id="confirm-popup" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-md w-80 text-center">
            <h3 id="popup-message" class="text-lg font-semibold mb-4">Apakah Anda yakin ingin melanjutkan aksi ini?</h3>
            <form id="confirm-form" action="{{ route('penyewaan.updateStatus') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="confirm-id">
                <input type="hidden" name="status" id="confirm-status">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                    Ya
                </button>
                <button type="button" onclick="closeConfirmPopup()" class="bg-gray-500 text-white px-4 py-2 rounded-md">
                    Tidak
                </button>
            </form>
        </div>
    </div>

    <!-- Script for Pop-up -->
    <script>
        function showConfirmPopup(id, status) {
            document.getElementById('confirm-id').value = id;
            document.getElementById('confirm-status').value = status;
            document.getElementById('popup-message').innerText =
                status === 'confirmed' ?
                'Apakah Anda yakin ingin mengonfirmasi penyewaan ini?' :
                'Apakah Anda yakin ingin menolak penyewaan ini?';
            document.getElementById('confirm-popup').classList.remove('hidden');
        }

        function closeConfirmPopup() {
            document.getElementById('confirm-popup').classList.add('hidden');
        }
    </script>
    @endsection
</x-app-layout>