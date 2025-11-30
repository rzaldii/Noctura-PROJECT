@extends('components.layout_organizer')

@section('title', 'Kelola Event')

@section('content')
<div class="container mx-auto max-w-7xl">
    <h1 class="text-3xl font-bold text-center mb-8">Daftar Event</h1>

    {{-- Button Tambah Event --}}
    <div class="mb-6">
        <a href="{{ route('organizer.events.create') }}"
           class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-semibold inline-block">
            + Tambah Event
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Event --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($events->isEmpty())
            <div class="p-8 text-center text-gray-500">
                Belum ada event. Klik "Tambah Event" untuk membuat event pertama.
            </div>
        @else
            <table class="w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4 text-left">Gambar</th>
                        <th class="p-4 text-left">Nama Event</th>
                        <th class="p-4 text-left">Lokasi</th>
                        <th class="p-4 text-left">Tanggal</th>
                        <th class="p-4 text-left">Button</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4">
                            @if($event->image_path)
                                <img src="{{ asset($event->image_path) }}"
                                     alt="Event"
                                     class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-xs">
                                    No Image
                                </div>
                            @endif
                        </td>
                        <td class="p-4 font-semibold">{{ $event->title }}</td>
                        <td class="p-4">
                            @if($event->event_type === 'offline')
                                {{ $event->address ?? '-' }}
                                @if($event->city), {{ $event->city }}@endif
                            @else
                                <span class="text-blue-600">Online Event</span>
                            @endif
                        </td>
                        <td class="p-4">
                            {{ \Carbon\Carbon::parse($event->start_time)->format('Y-m-d') }}
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                {{-- Manage Tiket --}}
                                <a href="{{ route('organizer.tickets.index', $event->id) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">
                                    Manage Tiket
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('organizer.events.edit', $event->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded text-sm">
                                    Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('organizer.events.destroy', $event->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin hapus event ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
