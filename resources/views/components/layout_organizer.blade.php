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
            <div class="flex items-center gap-2 cursor-pointer">
                <img src="{{ asset('images/logo noctura.png') }}" alt="Noctura Logo" class="h-12 w-auto">
                <h1 class="text-3xl font-bold cursor-pointer">Noctura</h1>
            </div>

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
            </nav>

            <!-- Profile Picture -->
            @php
                use App\Models\Organizer;

                $organizerData = null;

                if (session('user_id')) {
                    $organizerData = Organizer::find(session('user_id'));
                }
            @endphp

            <a href="{{ route('organizer.profile') }}" class="ml-4 flex items-center gap-3">
                <img
                    src="{{ $organizerData && $organizerData->image_path
                        ? asset($organizerData->image_path)
                        : asset('images/default_user.png') }}"
                    class="w-12 h-12 rounded-full object-cover border"
                    alt="Foto Profil">
                <p class="font-semibold text-xl">
                    {{ $organizerData ? $organizerData->username : 'Organizer' }}
                </p>
            </a>
        </div>
    </header>

    <main class="py-8 px-6 md:px-10">
        @yield('content')
    </main>

    @yield('scripts')

</body>
</html>
