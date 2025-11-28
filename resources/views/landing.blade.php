@extends('components.layout')

@section('title', 'Daftar Event')

@section('content')
<h1 class="text-4xl font-bold text-center pb-6">Hallooww, mau cari event apa nihh?</h1>
<div class="grid grid-cols-12 gap-10">
  <aside class="col-span-12 md:col-span-3 bg-white rounded-lg p-4 shadow-sm">
    <h3 class="font-bold mb-3 text-2xl text-center">Filter</h3>

    <form id="filterForm" action="{{ route('landing') }}" method="GET" class="space-y-4">
      <input type="hidden" name="q" value="{{ request('q') }}">

      <!-- City -->
      <div>
        <label class="block text-sm font-medium mb-2">Lokasi</label>
        <select name="city" class="w-full border rounded p-2 text-sm">
          <option value="">Semua Kota</option>
          @foreach($cities as $city)
            <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
              {{ $city }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Event Type -->
      <div>
        <label class="block text-sm font-medium mb-2">Tipe Event</label>
        <select name="event_type" class="w-full border rounded p-2 text-sm">
          <option value="">Semua Tipe</option>
          <option value="offline" {{ request('event_type')=='offline' ? 'selected' : '' }}>Offline</option>
          <option value="online" {{ request('event_type')=='online' ? 'selected' : '' }}>Online</option>
        </select>
      </div>

      <!-- Category -->
      <div>
        <label class="block text-sm font-medium mb-2">Kategori</label>
        <select name="category" class="w-full border rounded p-2 text-sm">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Time -->
      <div>
        <label class="block text-sm font-medium mb-2">Waktu</label>
        <select name="time" class="w-full border rounded p-2 text-sm">
          <option value="">Semua Waktu</option>
          <option value="today" {{ request('time') == 'today' ? 'selected' : '' }}>Hari Ini</option>
          <option value="week" {{ request('time') == 'week' ? 'selected' : '' }}>Minggu Ini</option>
          <option value="month" {{ request('time') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
          <option value="year" {{ request('time') == 'year' ? 'selected' : '' }}>Tahun Ini</option>
        </select>
      </div>

      <div class="flex gap-2 mt-3">
        <button type="submit" class="w-full bg-pink-600 text-white py-2 rounded">Terapkan</button>
        <a href="{{ route('landing') }}" class="w-full text-center border rounded py-2">Reset</a>
      </div>
    </form>
  </aside>

  <section class="col-span-12 md:col-span-9">
    <div class="mb-4">
      <p class="text-sm text-gray-600">
        Menampilkan {{ $events->firstItem() ?? 0 }} - {{ $events->lastItem() ?? 0 }} dari {{ $events->total() }} event
      </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach($events as $event)
        @php
          $minPrice = null;
          if ($event->tickets && $event->tickets->count()) {
              $prices = $event->tickets->pluck('price')->filter()->toArray();
              if (!empty($prices)) {
                  $minPrice = min($prices);
              }
          }
        @endphp

        <a href="#" class="block bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
          <div class="h-40 bg-gray-200">
            @if($event->image_path)
              <img src="{{ asset($event->image_path) }}" alt="{{ $event->title }}" class="object-cover w-full h-full">
            @else
              <div class="w-full h-full flex items-center justify-center text-gray-400">
                <span class="text-sm">No Image</span>
              </div>
            @endif
          </div>

          <div class="p-4">
            <h3 class="font-semibold text-sm leading-tight mb-1">{{ $event->title }}</h3>
            <p class="text-xs text-gray-500 mb-2">
              {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
              @if($event->city) • {{ $event->city }} @endif
            </p>

            {{-- Price --}}
            @if($minPrice !== null)
              <p class="text-sm font-semibold text-gray-900 mb-2">Mulai dari Rp{{ number_format($minPrice, 0, ',', '.') }}</p>
            @else
              <p class="text-sm font-semibold text-gray-900 mb-2">Harga belum tersedia</p>
            @endif

            <div class="text-xs text-gray-500 border-t pt-3">
              <span>{{ $event->organizer->organization_name ?? 'Unknown Organizer' }}</span>
            </div>
          </div>
        </a>
      @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $events->links('pagination::tailwind') }}
    </div>
  </section>
</div>
@endsection
