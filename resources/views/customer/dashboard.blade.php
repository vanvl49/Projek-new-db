<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Customer') }}
        </h2>
    </x-slot>
    @section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <p class="text-lg font-semibold text-gray-800">Welcome, {{ Auth::user()->nama }}!</p>
            <br>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Melihat Daftar Gedung -->
                <div class="bg-white border rounded-lg p-4 shadow-lg">
                    <a href="{{ route('customer.gedung') }}" class="text-lg font-semibold text-gray-800 hover:text-blue-600">
                        Gedung
                    </a>
                    <p class="text-gray-500 mt-2">Masuk ke page gedung</p>
                </div>

                <!-- Mencari Gedung -->
                <div class="bg-white border rounded-lg p-4 shadow-lg">
                    <a href="{{  route('penyewaan.customer') }}" class="text-lg font-semibold text-gray-800 hover:text-blue-600">
                        Penyewaan
                    </a>
                    <p class="text-gray-500 mt-2">All about penyewaan</p>
                </div>

                <!-- Melihat Ketersediaan Gedung -->
                <div class="bg-white border rounded-lg p-4 shadow-lg">
                    <a href="{{ route('riwayat.customer') }}" class="text-lg font-semibold text-gray-800 hover:text-blue-600">
                        Riwayat
                    </a>
                    <p class="text-gray-500 mt-2">Masuk ke page riwayat</p>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>