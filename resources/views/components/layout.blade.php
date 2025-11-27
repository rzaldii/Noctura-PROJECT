<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Noctura — @yield('title', 'Find Events')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900]">
  <header class="bg-gray-700 text-white">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center space-x-4">
        <h1 class="text-3xl font-bold cursor-pointer">Noctura</h1>
      </div>
            <!-- Search bar -->
    <form action="{{ route('landing') }}" method="GET" class="flex items-center w-full max-w-xl">
        <input
        type="text"
        name="q"
        value="{{ request('q') }}"
        placeholder="Cari event seru di sini"
        class="w-full rounded-full px-4 py-2 text-sm text-gray-900"
        />
        <button type="submit" class="bg-gray-800 px-4 py-2 rounded-full ml-2 my-1">
        Cari
        </button>
    </form>

      <nav class="flex items-center gap-2">
        <a href="{{ route('landing')}}" class="font-medium bg-gray-700 hover:bg-gray-600 rounded-md py-1 px-3 duration-500">Home</a>
        <a href="#" class="font-medium bg-gray-700 hover:bg-gray-600 rounded-md py-1 px-3 duration-500">About Us</a>
        <a href="#" class="font-medium bg-gray-700 hover:bg-gray-600 rounded-md py-1 px-3 duration-500">Contact</a>
    </nav>
    <a href="{{ route('login') ?? '#' }}" class="ml-4 bg-white text-gray-700 px-3 py-1 rounded-md font-medium hover:bg-gray-300 duration-500">Login</a>
    </div>
  </header>

    <main class="pt-6 pb-16 px-6 md:px-12">
        @yield('content')
    </main>

  <footer class="bg-gray-700 text-white mt-12">
    <div class="container mx-auto px-4 py-10 text-center text-sm">
      © 2025 Noctura - PWEB Kelompok 9
    </div>
  </footer>
</body>
</html>
