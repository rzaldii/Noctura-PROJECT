@extends('components.layout_organizer')

@section('title', 'Edit Tiket')

@section('content')
<div class="container mx-auto max-w-2xl">
    <h1 class="text-3xl font-bold mb-2">Edit Tiket untuk Event: <span class="text-pink-600">{{ $event->title }}</span></h1>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('organizer.tickets.update', $ticket->id) }}" method="POST" class="bg-white p-8 rounded-lg shadow">
        @csrf
        @method('PUT')

        {{-- Jenis Tiket --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Jenis Tiket <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $ticket->name) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                   placeholder="Contoh: VIP, Regular, Student" required>
        </div>

        {{-- Harga --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Harga <span class="text-red-500">*</span></label>
            <input type="number" name="price" value="{{ old('price', $ticket->price) }}" min="0" step="1000"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                   placeholder="50000" required>
            <p class="text-sm text-gray-500 mt-1">Harga dalam Rupiah</p>
        </div>

        {{-- Stok --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Stok <span class="text-red-500">*</span></label>
            <input type="number" name="stock" value="{{ old('stock', $ticket->stock) }}" min="1"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                   placeholder="100" required>
            <p class="text-sm text-gray-500 mt-1">
                Jumlah tiket yang tersedia.
                <strong>Terjual: {{ $ticket->sold }}</strong> |
                <strong>Tersisa: {{ $ticket->stock - $ticket->sold }}</strong>
            </p>
        </div>

        {{-- Min & Max Purchase --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block font-semibold mb-2">Min. Pembelian</label>
                <input type="number" name="min_purchase" value="{{ old('min_purchase', $ticket->min_purchase) }}" min="1"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
            <div>
                <label class="block font-semibold mb-2">Max. Pembelian</label>
                <input type="number" name="max_purchase" value="{{ old('max_purchase', $ticket->max_purchase) }}" min="1"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-4">
            <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-semibold">
                Update Tiket
            </button>
            <a href="{{ route('organizer.tickets.index', $event->id) }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
