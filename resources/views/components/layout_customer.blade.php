<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noctura — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">
    <header class="bg-gray-700 text-white shadow px-6">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between">

            <!-- Logo -->
            <div class="flex items-center gap-2 cursor-pointer">
                <img src="{{ asset('images/logo noctura.png') }}" alt="Noctura Logo" class="h-12 w-auto">
                <h1 class="text-3xl font-bold cursor-pointer">Noctura</h1>
            </div>

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
            <nav class="flex items-center space-x-2">

                <a href="{{ route('customer.dashboard') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Beranda
                </a>

                <a href="{{ route('customer.cart') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Keranjang
                </a>

                <a href="{{ route('customer.orders') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Riwayat
                </a>
            </nav>

            <!-- Profile Picture -->
            @php
                use App\Models\Customer;

                $customerData = null;

                if (session('user_id')) {
                    $customerData = Customer::find(session('user_id'));
                }
            @endphp

            <a href="{{ route('customer.profile') }}" class="ml-4 flex items-center gap-3">
                <img
                    src="{{ $customerData && $customerData->image_path
                        ? asset($customerData->image_path)
                        : asset('images/default_user.png') }}"
                    class="w-12 h-12 rounded-full object-cover border"
                    alt="Foto Profil">
                <p class="font-semibold text-xl">
                    {{ $customerData ? $customerData->username : 'Customer' }}
                </p>
            </a>

        </div>
    </header>


    <!-- CONTENT -->
    <main class="py-8 px-6 md:px-10">
        @yield('content')
    </main>

    @yield('scripts')

</body>
</html>
