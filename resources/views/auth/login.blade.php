@extends('components.layout')
@section('title', 'Login ')
@section('content')

<div class="w-3/4 h-auto flex shadow-lg bg-white rounded-3xl overflow-hidden mx-auto justify-center mt-6">
    <!-- kiri -->
    <div class="hidden lg:flex w-1/2 relative">
        <img src="{{ asset('images/event.jpeg') }}"
             class="absolute inset-0 w-full h-full object-cover" alt="Event">
        <div class="absolute inset-0 bg-gray-700/60"></div>
        <div class="relative z-10 flex items-center justify-center w-full">
            <h1 class="text-5xl font-bold text-white tracking-wide">
                Noctura
            </h1>
        </div>
    </div>

    <!-- kanan -->
    <div class="w-full lg:w-1/2 flex items-center justify-center px-10">
        <div class="w-full max-w-md py-12">
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
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" placeholder="Password"
                        class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Login sebagai</label>

                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="role" value="customer" required>
                            Customer
                        </label>

                        <label class="flex items-center gap-2">
                            <input type="radio" name="role" value="organizer">
                            Event Organizer
                        </label>
                    </div>
                </div>

                <button type="submit"
                    class="w-full p-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition">
                    Login
                </button>
            </form>

            <p class="mt-6 text-sm text-center">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-gray-600 font-semibold hover:underline">
                    Daftar sekarang
                </a>
            </p>

        </div>
    </div>
</div>
@endsection
