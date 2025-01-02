<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.10.2/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.5/fullcalendar.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.5/fullcalendar.min.js"></script>


</head>


<body>
    <!-- page -->
    <main class="min-h-screen w-full bg-gray-100 h-fit" x-data="layout">
        <!-- header page -->
        <header class="px-4 flex w-full items-center justify-between border-b-2 border-gray-100 bg-white sticky top-0 z-50">
            <!-- logo -->
            <div class="flex items-center space-x-2">
                <button type="button" class="text-3xl" @click="asideOpen = !asideOpen"><i class="bx bx-menu"></i></button>
                <div class="mb-2 sm:mb-0 flex flex-row">
                    <div class="h-10 w-10 self-center mr-2">
                        <img class="h-10 w-10 self-center" src="https://upload.wikimedia.org/wikipedia/commons/d/d4/Logo_unej.png" />
                    </div>
                    <div>
                        <a href="{{ route('home') }}" class="text-2xl no-underline text-grey-darkest hover:[#c01315] font-sans font-bold ">GedungIn UNEJ</a><br>
                        <span class="text-xs text-grey-dark invisible md:visible">Website Penyewaan Gedung UNEJ</span>
                    </div>
                </div>
            </div>

            <div class="sm:mb-0 self-center">
                <!-- <div class="h-10" style="display: table-cell, vertical-align: middle;"> -->
                <a href="{{ route('home') }}" class="text-md no-underline hover:underline text-black hover:text-[#c01315] ml-2 px-1 font-poppins transition-colors invisible md:visible">Home</a>
                <!-- Tampilkan tombol Sign In jika di halaman landing page -->
                <!-- <a href="/two" class="text-lg no-underline text-grey-darkest hover:text-blue-dark ml-2">About Us</a> -->
                @if (Route::currentRouteName() === 'home')
                <!-- Tampilkan tombol Sign In jika di halaman landing page -->
                <a href="{{ route('login') }}" class="font-poppins bg-[#c01315] text-white px-4 py-2 rounded hover:bg-white hover:text-[#c01315] transition-colors ml-2 hover:underline">
                    Sign In
                </a>
                @else
                <a href="{{ route('customer.gedung') }}" class="text-md no-underline hover:underline text-black hover:text-[#c01315] ml-2 px-1 font-poppins transition-colors invisible md:visible">Gedung</a>
                <!-- Tampilkan tombol Sign Out jika di halaman lain -->
                <form method="POST" action="{{ auth()->guard('admin')->check() ? route('logout.admin') : route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="font-poppins bg-[#c01315] text-white px-4 py-2 rounded hover:bg-white hover:text-[#c01315] transition-colors ml-2 hover:underline">
                        Sign Out
                    </button>
                </form>
                @endif
                <!-- </div> -->

            </div>
        </header>

        <div class="flex min-h-screen">
            <aside class="flex w-72 flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2 fixed sm:relative z-40 transition-all duration-300 transform" :class="{'-translate-x-full': !asideOpen, 'translate-x-0': asideOpen}" x-show="asideOpen">

                <!-- Sidebar untuk Customer (Web) -->
                <div class="customer-sidebar">
                    @auth('web')
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-[#c01315]">
                        <span class="text-2xl"><i class="bx bx-home"></i></span>
                        <span>Dashboard User</span>
                    </a>
                    <a href="{{ route('penyewaan.customer') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-[#c01315]">
                        <span class="text-2xl"><i class="bx bx-building-house"></i></span>
                        <span>Penyewaan</span>
                    </a>
                    <a href="{{ route('riwayat.customer') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-[#c01315]">
                        <span class="text-2xl"><i class="bx bx-history"></i></span>
                        <span>Riwayat Penyewaan</span>
                    </a>
                    @endauth
                </div>

                <!-- Sidebar untuk Admin (Admin) -->
                <div class="admin-sidebar">
                    @auth('admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-[#c01315]">
                        <span class="text-2xl"><i class="bx bx-home"></i></span>
                        <span>Dashboard Admin</span>
                    </a>
                    <a href="{{ route('gedung.index') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-[#c01315]">
                        <span class="text-2xl"><i class="bx bx-building-house"></i></span>
                        <span>Gedung</span>
                    </a>
                    <a href="{{ route('penyewaan.pending') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-[#c01315]">
                        <span class="text-2xl"><i class="bx bx-calendar"></i></span>
                        <span>Penyewaan</span>
                    </a>
                    <a href="{{ route('riwayat.admin') }}" class="flex items-center space-x-1 rounded-md px-2 py-3 hover:bg-gray-100 hover:text-[#c01315]">
                        <span class="text-2xl"><i class="bx bx-history"></i></span>
                        <span>Riwayat</span>
                    </a>
                    @endauth
                </div>

            </aside>
            <!-- main content page -->
            <div class="w-full">
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
    @stack('scripts')

</html>