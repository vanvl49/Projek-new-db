<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
</head>

<!-- page -->
<main class="min-h-screen w-full bg-gray-50 @yield('bg-image-class') h-fit" x-data="layout">
    <!-- header page -->
    <header class="flex w-full items-center justify-between border-b-2 border-gray-100 bg-white p-2 sticky top-0 z-50">
        <!-- logo -->
        <div class="flex items-center space-x-2">
            <button type="button" class="text-3xl" @click="asideOpen = !asideOpen"><i class="bx bx-menu"></i></button>
            <div class="mb-2 sm:mb-0 flex flex-row">
                <div class="h-10 w-10 self-center mr-2">
                    <img class="h-10 w-10 self-center" src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Logo_unej.png" />
                </div>
                <div>
                    <a href="/home" class="text-2xl no-underline text-grey-darkest hover:text-blue-dark font-sans font-bold ">GedungIn UNEJ</a><br>
                    <span class="text-xs text-grey-dark invisible md:visible">Website Penyewaan Gedung UNEJ</span>
                </div>
            </div>
        </div>

        <div class="sm:mb-0 self-center">
            <!-- <div class="h-10" style="display: table-cell, vertical-align: middle;"> -->
            <a href="" class="text-md no-underline hover:underline text-black hover:text-[#c01315] ml-2 px-1 font-poppins transition-colors invisible md:visible">Home</a>
            <a href="{{ route('home') }}" class="text-md no-underline hover:underline text-black hover:text-[#c01315] ml-2 px-1 font-poppins transition-colors invisible md:visible">Gedung</a>
            <!-- <a href="/two" class="text-lg no-underline text-grey-darkest hover:text-blue-dark ml-2">About Us</a> -->
            @if (Route::currentRouteName() === 'home')
            <!-- Tampilkan tombol Sign In jika di halaman landing page -->
            <a href="{{ route('login') }}" class="font-poppins bg-[#c01315] text-white px-4 py-2 rounded hover:bg-white hover:text-[#c01315] transition-colors ml-2 hover:underline">
                Sign In
            </a>
            @else
            <!-- Tampilkan tombol Sign Out jika di halaman lain -->
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="font-poppins bg-[#c01315] text-white px-4 py-2 rounded hover:bg-white hover:text-[#c01315] transition-colors ml-2 hover:underline">
                    Sign Out
                </button>
            </form>
            @endif
            <!-- </div> -->

        </div>
    </header>

    <div class="flex">
        <!-- aside -->
        <aside class="flex w-72 flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2" style="height: 90.5vh"
            x-show="asideOpen">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                <span class="text-2xl"><i class="bx bx-home"></i></span>
                <span>Beranda</span>
            </a>

            <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                <span class="text-2xl"><i class="bx bx-cart"></i></span>
                <span>Penyewaan</span>
            </a>

            <a href="#" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-blue-600">
                <span class="text-2xl"><i class="bx bx-shopping-bag"></i></span>
                <span>Riwayat Penyewaan</span>
            </a>
        </aside>

        <!-- main content page -->
        <div class="w-full p-4">
            @yield('content')
        </div>
    </div>
    <!-- footer -->
    @include('layouts.footer')
</main>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("layout", () => ({
            profileOpen: false,
            asideOpen: false,
        }));
    });
</script>