<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EO — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- NAVBAR EO --}}
    <header class="bg-gray-700 text-white">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between">

            <a href="{{ route('organizer.dashboard') }}" class="text-3xl font-bold">Noctura</a>

            <nav class="flex items-center space-x-6">
                <a href="{{ route('organizer.dashboard') }}" class="hover:underline">Dashboard</a>
                <a href="{{ route('organizer.events') }}" class="hover:underline">Kelola Event</a>
                <a href="{{ route('organizer.orders') }}" class="hover:underline">Pemesanan</a>
            </nav>

            {{-- Profile --}}
            <a href="{{ route('organizer.profile') }}" class="flex items-center space-x-2">
                <img src="{{ asset(session('user.image')) }}"
                     class="w-8 h-8 rounded-full object-cover">
                <span>{{ session('user.fullname') }}</span>
            </a>

        </div>
    </header>

    <main class="px-6 py-8">
        @yield('content')
    </main>

</body>
</html>
