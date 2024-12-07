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
            <div class="flex flex-col items-center space-y-4">
                <p class="text-gray-700 font-medium">Start as:</p>
                <div class="flex space-x-4">
                    <a href="{{ route('login') }}" 
                        class="inline-flex items-center justify-center w-36 text-white bg-blue-600 border-0 py-2 px-4 focus:outline-none hover:bg-blue-700 rounded text-md transition">
                        Customer
                    </a>
                    <button onclick="openAdminLogin()" 
                        class="inline-flex items-center justify-center w-36 text-white bg-green-600 border-0 py-2 px-4 focus:outline-none hover:bg-green-700 rounded text-md transition">
                        Admin
                    </button>
                </div>
            </div>
        </div>
        <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
            <img class="object-cover object-center rounded" alt="hero" src="https://unej.ac.id/wp-content/uploads/2022/06/unejheader2023-1-600x337.webp">
        </div>
    </div>
</section>

<div id="adminLoginModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Admin Login</h2>
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-medium mb-2">Username</label>
                <input type="text" name="username" id="username" 
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter admin username" required />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" id="password" 
                    class="w-full px-4 py-2 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Enter admin password" required />
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeAdminLogin()" 
                    class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500 mr-2">
                    Cancel
                </button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAdminLogin() {
        document.getElementById('adminLoginModal').classList.remove('hidden');
    }

    function closeAdminLogin() {
        document.getElementById('adminLoginModal').classList.add('hidden');
    }
</script>
@endsection
