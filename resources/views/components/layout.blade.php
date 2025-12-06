<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>Noctura — @yield('title', 'Find Events')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Iconify & JQuery -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="bg-gray-100 min-h-screen font-[Poppins] text-gray-800">

    {{-- HEADER / NAVBAR --}}
    <header class="bg-gray-700 text-white shadow">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-2 cursor-pointer">
                <img src="{{ asset('images/logo noctura.png') }}" alt="Noctura Logo" class="h-12 w-auto">
                <h1 class="text-3xl font-bold cursor-pointer">Noctura</h1>
            </div>

            <!-- Search bar -->
            <form action="{{ route('landing') }}" method="GET"
                  class="flex items-center w-full max-w-xl mx-6">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari event seru di sini"
                    class="w-full rounded-full px-4 py-2 text-sm text-gray-900 outline-none"
                />
                <button type="submit"
                        class="bg-gray-800 px-4 py-2 rounded-full ml-2 my-1 hover:bg-gray-900 duration-300">
                    Cari
                </button>
            </form>

            <!-- Navbar link -->
            <nav class="flex items-center gap-2">
                <a href="{{ route('landing')}}" class="font-medium bg-gray-700 hover:bg-gray-600 rounded-md py-1 px-3 duration-500">Home</a>
                <a href="{{ route('about')}}" class="font-medium bg-gray-700 hover:bg-gray-600 rounded-md py-1 px-3 duration-500">About Us</a>
                <a href="{{ route('contact')}}" class="font-medium bg-gray-700 hover:bg-gray-600 rounded-md py-1 px-3 duration-500">Contact</a>

            <!-- Login Button -->
            <a href="{{ route('login.clear') }}"
               class="ml-8 bg-white text-gray-700 px-3 py-1 rounded-md font-semibold hover:bg-gray-300 duration-300">
                Login
            </a>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="pt-6 pb-16 px-6 md:px-12">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-700 text-white mt-12">
        <div class="container mx-auto px-4 py-10 text-center text-sm">
            © 2025 Noctura - PWEB Kelompok 9
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
