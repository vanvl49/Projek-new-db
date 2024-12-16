@extends('layouts.app')

@section('title', 'Login')

@section('bg-image-class', 'bg-[url("https://unej.ac.id/wp-content/uploads/2023/07/bgheaderunej.webp")] bg-cover bg-center backdrop-blur-lg')

@section('content')
<section class="">
    <x-auth-session-status class="" :status="session('status')" />
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="{{ route('home') }}" class="text-4xl font-poppins  font-extrabold text-black mb-2"> SEWA GEDUNG UNEJ </a>
        <div class="w-full bg-white rounded-lg shadow bg-opacity-50 shadow-lg backdrop-blur-md  md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-black md:text-2xl text-center">
                    Admin Login
                </h1>

                @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="space-y-4 md:space-y-6" action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-black">Username</label>
                        <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-black rounded-lg focus:ring-[#c01315] focus:border-[#c01315] block w-full p-2.5" placeholder="username" required="" />
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-black">Password</label>
                        <input type="password" name="password" id="password" placeholder="********" class="bg-gray-50 border border-gray-300 text-black rounded-lg focus:ring-[#c01315] focus:border-[#c01315] block w-full p-2.5" required="" />
                    </div>
                    <button type="submit" class="w-full text-white bg-[#c01315] hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-red-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Login</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection