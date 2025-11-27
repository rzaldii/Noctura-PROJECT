<nav class="w-full bg-gray-800 py-5 px-10 flex items-center justify-between shadow-md">
    <div class="flex items-center space-x-3">
        <img src="{{ asset('images/logo.jpg') }}"
        alt="Logo Noctura"
        class="w-10 h-10 object-contain mix-blend-screen"> {{--logonya msh ga transparan--}}

        <h1 class="text-white text-2xl font-semibold tracking-wide">Noctura</h1>

        <span class="text-blue-200 text-sm font-medium">
            Beli tiketmu sekarang!
        </span>
    </div>

    <div class="flex items-center space-x-6">
        <div class="hidden md:flex items-center space-x-6 px-7 py-2">
            <a href="#" class="text-white text-sm font-medium hover:text-blue-200 transition">Beranda</a>
            <a href="#" class="text-white text-sm font-medium hover:text-blue-200 transition">Tentang</a>
            <a href="#" class="text-white text-sm font-medium hover:text-blue-200 transition">Hubungi Kami</a>
        </div>

        <a href="{{ route('login') }}"
            class="bg-gray-700 hover:bg-blue-700 text-white text-sm font-semibold py-2 px-5 rounded-full shadow-md transition">
            Login
        </a>
    </div>
</nav>
