@extends('layouts.app')

@section('title','Daftar Gedung')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-xl font-semibold">Gedung yang Tersedia</h3>

                <!-- Form Filter -->
                <form action="{{ route('customer.gedung') }}" method="GET" class="mb-6">
                    <div class="flex items-center gap-4">
                        <!-- Input Search Nama Gedung -->
                        <input
                            type="text"
                            name="nama_gedung"
                            class="border rounded-lg px-4 py-2 w-48"
                            placeholder="Cari nama gedung"
                            value="{{ $request->nama_gedung ?? '' }}">

                        <!-- Input Filter Kapasitas -->
                        <input
                            type="number"
                            name="kapasitas"
                            class="border rounded-lg px-4 py-2 w-48"
                            placeholder="Minimal Kapasitas"
                            value="{{ $request->kapasitas ?? '' }}">

                        <!-- Tombol Submit -->
                        <button
                            type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                            Cari
                        </button>
                    </div>
                </form>

                <!-- Tampilkan data gedung sebagai card -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                    @if($gedungs->isEmpty())
                    <p class="text-center text-gray-500">Belum ada gedung yang tersedia.</p>
                    @else
                    @foreach($gedungs as $gedung)
                    <div class="transform hover:scale-105 transition-transform duration-300 ease-in-out">
                        <div class="border rounded-lg p-4 shadow-lg bg-white hover:shadow-2xl">
                            <img src="{{ asset('storage/' . $gedung->gambar_gedung) }}" alt="Gambar Gedung" class="w-full h-40 object-cover rounded-lg mb-4">
                            <h3 class="text-lg font-semibold mt-2">{{ $gedung->nama_gedung }}</h3>
                            <p class="text-gray-600 mt-2">{{ $gedung->deskripsi }}</p>
                            <p class="text-sm text-gray-500 mt-2">Kapasitas: {{ $gedung->kapasitas }} orang</p>
                            <p class="text-sm text-gray-500">Harga: Rp {{ number_format($gedung->harga_tampil, 0, ',', '.') }}</p>

                            <div class="mt-4 text-center">
                                <a href="{{ route('customer.show', ['id' => $gedung->id]) }}" class="text-white bg-blue-500 px-4 py-2 rounded-full hover:bg-blue-600 transition-colors">Sewa Gedung</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection