@extends('components.template')
@section('title', 'Login ')
@section('content')

<div class="min-h-screen flex">
    <!-- kiri -->
    <div class="hidden lg:flex w-1/2 relative">
        <img src="{{ asset('images/event.jpeg') }}"
             class="absolute inset-0 w-full h-full object-cover" alt="Event">
        <div class="absolute inset-0 bg-blue-900/60"></div>
        <div class="relative z-10 flex items-center justify-center w-full">
            <h1 class="text-5xl font-bold text-white tracking-wide">
                Noctura
            </h1>
        </div>
    </div>

    <!-- kanan -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-10">
        <div class="w-full max-w-md">
            <h1 class="text-3xl font-semibold text-blue-700 mb-8">
                Noctura
            </h1>

            <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                Selamat datang kembali!
            </h2>
            <p class="text-gray-600 mb-8">
                Silakan masuk untuk melanjutkan ke akun Anda.
            </p>

            <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" placeholder="Email"
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <button type="submit"
                    class="w-full p-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Login
                </button>
            </form>

            <p class="mt-6 text-sm text-center">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>

        </div>
    </div>
</div>
@endsection
