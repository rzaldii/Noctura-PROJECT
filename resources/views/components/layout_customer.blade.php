<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noctura — @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- NAVBAR CUSTOMER -->
    <header class="bg-gray-700 text-white shadow">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between">

            <!-- Logo -->
            <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold">
                Noctura
            </a>

            <!-- Search Bar -->
            <form action="{{ route('customer.dashboard') }}" method="GET" class="flex items-center w-full max-w-lg mx-6">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari event yang kamu mau..."
                    class="w-full px-4 py-2 text-sm rounded-full text-gray-900"
                >
                <button class="ml-2 px-4 py-2 bg-gray-800 rounded-full">
                    Cari
                </button>
            </form>

            <!-- Menu -->
            <nav class="flex items-center space-x-4">

                <a href="{{ route('customer.dashboard') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Beranda
                </a>

                <a href="{{ route('customer.cart') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Keranjang
                </a>

                <a href="{{ route('customer.history') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Riwayat
                </a>

                <!-- Profile Picture -->
                <a href="{{ route('login') }}">
                    <img
                        src="{{ asset(Auth::user()->image ?? 'images/default-avatar.png') }}"
                        class="w-9 h-9 rounded-full border-2 border-white object-cover ml-6"
                        alt="Profile"
                    >
                </a>

            </nav>

        </div>
    </header>


    <!-- CONTENT -->
    <main class="py-8 px-6 md:px-10">
        @yield('content')
    </main>

</body>
</html>
