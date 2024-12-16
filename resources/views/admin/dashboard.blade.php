<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    @section('content')
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Content Area -->
        <div class="content-area bg-gray-100 p-6 rounded-lg shadow-lg w-full">

            <!-- Topbar -->
            <div class="topbar bg-white shadow-md flex justify-between p-4 mb-6 rounded-lg">
                <div class="greeting">
                    <h3 class="font-sans font-medium text-2xl text-gray-800">Selamat datang, Admin</h3>
                    <span id="currentDate" class="text-gray-600 text-sm"></span>
                </div>
            </div>

            <!-- Overview -->
            <div class="overview grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <!-- Total Gedung Tersedia -->
                <div class="card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <h4 class="font-semibold text-gray-700 text-lg">Total Gedung Tersedia</h4>
                    <p class="text-3xl font-bold text-red-600">{{ $totalGedung }}</p>
                </div>
            
                <!-- Total Penyewa Aktif -->
                <div class="card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <h4 class="font-semibold text-gray-700 text-lg">Total Penyewaan</h4>
                    <p class="text-3xl font-bold text-red-600">{{ $totalPenyewaAktif }}</p>
                </div>
            
                <!-- Penyewaan Terbaru -->
                <div class="card bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow">
                    <h4 class="font-semibold text-gray-700 text-lg">Penyewaan Terbaru</h4>
                    @if($penyewaanTerbaru && $penyewaanTerbaru->gedung && $penyewaanTerbaru->user)
                        <p class="text-gray-600">{{ $penyewaanTerbaru->gedung->nama_gedung }} - {{ $penyewaanTerbaru->user->nama }}</p>
                    @else
                        <p class="text-gray-600">Tidak ada penyewaan yang dikonfirmasi.</p>
                    @endif
                </div>                                 
            </div>

            <!-- Charts -->
            <div class="charts mt-6">
                <div class="chart bg-white rounded-lg shadow-md p-6">
                    <h4 class="text-lg font-semibold text-gray-700">Grafik Penyewaan Bulanan</h4>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>

<script>
    // JavaScript untuk menampilkan tanggal dinamis
    document.addEventListener("DOMContentLoaded", function () {
        const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
        const months = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];

        const now = new Date();
        const day = days[now.getDay()];
        const date = now.getDate();
        const month = months[now.getMonth()];
        const year = now.getFullYear();

        const formattedDate = `${day}, ${date} ${month} ${year}`;
        document.getElementById("currentDate").innerText = formattedDate;
    });
    
    // const confirmedData = @json($confirmedData);
    // const rejectedData = @json($rejectedData);
    const labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const ctx = document.getElementById('barChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Confirmed',
                    data: confirmedData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)', // Biru
                },
                {
                    label: 'Rejected',
                    data: rejectedData,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)', // Merah
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: { mode: 'index', intersect: false },
            },
            scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true },
            }
        }
    });
</script>
