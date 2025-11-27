@extends('components.template')
@section('title', 'Register ')
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
        <div class="w-full max-w-sm">
            <h1 class="text-xl font-semibold text-blue-700 mb-6">
                Noctura
            </h1>

            <h2 class="text-lg font-semibold text-gray-900 mb-1">
                Buat akun baru
            </h2>
            <p class="text-gray-600 mb-6 text-xs">
                Silakan isi data di bawah untuk membuat akun baru.
            </p>

            <form action="{{ route('register.process') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Nama Lengkap</label>
                    <input type="text" name="fullname"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Username</label>
                    <input type="text" name="username"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Email</label>
                    <input type="email" name="email"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Password</label>
                    <input type="password" name="password"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-400"
                        required>
                </div>

                <button type="submit"
                    class="w-full p-2.5 bg-blue-600 text-white rounded-lg font-semibold text-xs hover:bg-blue-700 transition">
                    Daftar
                </button>
            </form>

            <p class="mt-4 text-xs text-center">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-blue-600 font-semibold hover:underline">
                    Masuk di sini
                </a>
            </p>

        </div>
    </div>
</div>
@endsection
