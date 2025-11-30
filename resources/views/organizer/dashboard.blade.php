@extends('components.layout_organizer')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-center mb-8">Dashboard Event Organizer</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-sm uppercase tracking-wide mb-2">Total Event</div>
            <div class="text-4xl font-bold">{{ $totalEvents }}</div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-sm uppercase tracking-wide mb-2">Tiket Terjual</div>
            <div class="text-4xl font-bold">{{ $totalTicketsSold }}</div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-sm uppercase tracking-wide mb-2">Total Pelanggan</div>
            <div class="text-4xl font-bold">{{ $totalCustomers }}</div>
        </div>

        <div class="bg-gradient-to-br from-pink-500 to-pink-600 text-white rounded-lg shadow-lg p-6 text-center">
            <div class="text-sm uppercase tracking-wide mb-2">Total Pendapatan</div>
            <div class="text-3xl font-bold">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

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
                                <th class="p-3 text-center">Tiket Terjual</th>
                                <th class="p-3 text-center">Pendapatan</th>
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
                                    @if($event->event_type === 'offline')
                                        {{ $event->address ?? '-' }}
                                        @if($event->city), {{ $event->city }}@endif
                                    @else
                                        <span class="text-blue-600 font-semibold">Online Event</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
                                </td>
                                <td class="p-3 text-center">
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full font-semibold">
                                        {{ $event->tickets_sold }}
                                    </span>
                                </td>
                                <td class="p-3 text-center">
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">
                                        Rp{{ number_format($event->revenue, 0, ',', '.') }}
                                    </span>
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
