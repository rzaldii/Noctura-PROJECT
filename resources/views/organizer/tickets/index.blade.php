@extends('components.layout_organizer')

@section('title', 'Manage Tiket')

@section('content')
<div class="container mx-auto max-w-6xl">
    <h1 class="text-3xl font-bold mb-2">Daftar Tiket Event: <span class="text-pink-600">{{ $event->title }}</span></h1>

    {{-- Button Kembali & Tambah Tiket --}}
    <div class="flex gap-4 mb-6">
        <a href="{{ route('organizer.events') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold">
            ← Kembali ke Event
        </a>
        <a href="{{ route('organizer.tickets.create', $event->id) }}"
           class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-semibold">
            + Tambah Tiket
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Tiket --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($tickets->isEmpty())
            <div class="p-8 text-center text-gray-500">
                Belum ada tiket untuk event ini. Klik "Tambah Tiket" untuk mulai membuat tiket.
            </div>
        @else
            <table class="w-full">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="p-4 text-left">Jenis Tiket</th>
                        <th class="p-4 text-left">Harga</th>
                        <th class="p-4 text-left">Stok</th>
                        <th class="p-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 font-semibold">{{ $ticket->name }}</td>
                        <td class="p-4">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="font-semibold">{{ $ticket->stock - $ticket->sold }}</span> / {{ $ticket->stock }}
                            <span class="text-sm text-gray-500">(Terjual: {{ $ticket->sold }})</span>
                        </td>
                        <td class="p-4">
                            <div class="flex gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('organizer.tickets.edit', $ticket->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded text-sm">
                                    Edit
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('organizer.tickets.destroy', $ticket->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin hapus tiket ini?')">
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
