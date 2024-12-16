@extends('layouts.app')

@section('title','Welcome!')

@section('content')
<section class="text-black body-font bg-gray-50">
    <div class="container mx-auto flex px-5 py-24 md:flex-row flex-col items-center">
        <div class="lg:flex-grow md:w-1/2 lg:pr-24 md:pr-16 flex flex-col md:items-start md:text-left mb-16 md:mb-0 items-center text-center">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Easier Transaction,
                <br class="hidden lg:inline-block">Proses Penyewaan Gedung Jadi Mudah!
            </h1>
            <p class="mb-8 leading-relaxed">
                Experience hassle-free booking to UNEJ building with our platform.
                Whether you're organizing events or reserving spaces, our platform simplifies the process with intuitive navigation. Designed for those who value convenience and efficiency, our system ensures you stay on top of your plans without the stress!
            </p>
            <div class="flex justify-center">
                <button onclick="openSelectRole()" class="inline-flex text-white hover:text-[#c01315] bg-[#c01315] border-0 py-2 px-10 focus:outline-none hover:bg-white rounded text-lg">
                    Get Started
                </button>
            </div>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded" alt="hero" src="https://unej.ac.id/wp-content/uploads/2022/06/unejheader2023-1-600x337.webp">
        </div>
    </div>
</section>

<div id="selectRoleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full text-center relative">
        <!-- Close Button -->
        <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800" onclick="closeSelectRole()">
            <i class="fas fa-times"></i>
        </button>

        <h1 class="text-2xl font-semibold mb-4">Get Started As</h1>
        <p class="text-gray-500 mb-8">Pilih Role Anda</p>
        <div class="flex justify-center space-x-4 mb-8">
            <!-- Customer Option -->
            <a href="{{ route('login') }}" class="flex flex-col items-center p-4 bg-opacity-50 border-2 border-[#c01315] rounded-lg cursor-pointer hover:bg-[#c01315] hover:text-white">
                <!-- <i class="fas fa-user-graduate text-4xl text-gray-300 mb-2"></i> -->
                <span class="text-[#c01315] hover:text-white">Customer</span>
            </a>
            <!-- Admin Option -->
            <a href="{{ route('login.admin') }}" class="flex flex-col items-center p-4 bg-opacity-50 border-2 border-[#c01315] rounded-lg cursor-pointer hover:bg-[#c01315] hover:text-white">
                <!-- <i class="fas fa-chalkboard-teacher text-4xl text-blue-500 mb-2"></i> -->
                <span class="text-[#c01315] hover:text-white">Admin</span>
            </a>
        </div>
    </div>
</div>




<script>
    function openSelectRole() {
        document.getElementById('selectRoleModal').classList.remove('hidden');
    }

    function closeSelectRole() {
        document.getElementById('selectRoleModal').classList.add('hidden');
    }
</script>
@endsection