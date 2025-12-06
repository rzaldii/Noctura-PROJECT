@extends('components.layout')
@section('title', 'Register ')
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
        <div class="w-full max-w-sm py-12">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">
                Buat akun baru
            </h2>
            <p class="text-gray-600 mb-6 text-xs">
                Silakan isi data di bawah untuk membuat akun baru.
            </p>

            @if($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-3 text-center">
                {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('register.process') }}" method="POST" id="registerForm" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Nama Lengkap</label>
                    <input type="text" name="fullname"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-gray-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Username</label>
                    <input type="text" name="username" maxlength="15"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-gray-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Email</label>
                    <input type="email" name="email"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-gray-400"
                        required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Password</label>
                    <input type="password" name="password"
                        class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-gray-400"
                        required>
                </div>

                <div id="eoFields" class="hidden">

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Logo EO</label>
                        <input type="file" name="image"
                            class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-gray-400">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Deskripsi EO</label>
                        <textarea name="description"
                                class="w-full p-2.5 border rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-gray-400"></textarea>
                    </div>

                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1 text-xs">Daftar sebagai</label>

                    <div class="flex items-center gap-4 text-xs">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="role" value="customer">
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
                    Daftar
                </button>
            </form>

            <p class="mt-4 text-xs text-center">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-gray-600 font-semibold hover:underline">
                    Masuk di sini
                </a>
            </p>

        </div>
    </div>
</div>
@endsection


@section('scripts')
{{-- SUCCESS REGISTER --}}
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil Membuat Akun!',
    text: '{{ session("success") }}',
    confirmButtonColor: "#4B5563",
    confirmButtonText: "OK"
});
</script>
@endif

<script>
// Tampilkan EO fields jika pilih role EO
document.querySelectorAll('input[name="role"]').forEach(r => {
    r.addEventListener('change', () => {
        document.getElementById('eoFields').classList.toggle('hidden', r.value !== 'organizer');
    });
});

// Validasi front-end password minimal 5 karakter
document.getElementById("registerForm").addEventListener("submit", function(e){
    const pwd = document.querySelector('input[name="password"]').value;
    const role = document.querySelector('input[name="role"]:checked');

    if(!role){
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Pilih Role!',
            text: 'Silakan pilih Customer atau Event Organizer.'
            confirmButtonColor: "#4B5563",
            confirmButtonText: "OK"
        });
        return;
    }

    if(pwd.length < 3){
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Password Terlalu Pendek!',
            text: 'Minimal 5 karakter.'
            confirmButtonColor: "#4B5563",
            confirmButtonText: "OK"
        });
    }
});
</script>
@endsection
