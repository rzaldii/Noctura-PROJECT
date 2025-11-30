@extends('components.layout_organizer')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-center mb-6">Daftar Event</h1>

    {{-- Event List (READ ONLY - NO BUTTONS) --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b flex justify-between items-center">
            <h2 class="font-semibold text-lg">Event Saya</h2>
            <a href="{{ route('organizer.events') }}" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700">
                + Kelola Event
            </a>
        </div>

        <div class="p-4">
            @if($events->isEmpty())
                <p class="text-gray-500 text-center py-8">
                    Belum ada event. Klik "Kelola Event" untuk membuat event baru.
                </p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full table-auto text-left">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="p-3">Gambar</th>
                                <th class="p-3">Nama Event</th>
                                <th class="p-3">Lokasi</th>
                                <th class="p-3">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 w-24">
                                    @if($event->image_path)
                                        <img src="{{ asset($event->image_path) }}"
                                             alt="Event"
                                             class="w-20 h-20 object-cover rounded">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center text-sm text-gray-500">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td class="p-3 font-semibold">{{ $event->title }}</td>
                                <td class="p-3">
                                    {{ $event->address ?? '-' }}
                                    @if($event->city)
                                        , {{ $event->city }}
                                    @endif
                                </td>
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
