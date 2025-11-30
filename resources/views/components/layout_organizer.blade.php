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

    {{-- NAVBAR EO --}}
    <header class="bg-gray-700 text-white shadow">
        <div class="container mx-auto px-6 py-3 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('organizer.dashboard') }}" class="text-2xl font-bold">
                Noctura
            </a>

            <nav class="flex items-center space-x-4">
                <a href="{{ route('organizer.dashboard') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Dashboard
                </a>

                <a href="{{ route('organizer.events') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Kelola Event
                </a>

                <a href="{{ route('organizer.orders') }}"
                   class="hover:bg-gray-600 px-3 py-1 rounded-md duration-300">
                    Pemesanan
                </a>

                {{-- Profile --}}
                <a href="{{ route('organizer.profile') }}">
                    <img src="{{ asset(session('user.image', 'images/default-avatar.png')) }}"
                         class="w-9 h-9 rounded-full border-2 border-white object-cover ml-6"
                         alt="{{ session('user.fullname', 'Organizer') }}">
                </a>
            </nav>

        </div>
    </header>

    <main class="py-8 px-6 md:px-10">
        @yield('content')
    </main>

</body>
</html>
