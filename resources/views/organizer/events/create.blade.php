@extends('components.layout_organizer')

@section('title', 'Tambah Event')

@section('content')
<div class="container mx-auto max-w-3xl">
    <h1 class="text-3xl font-bold mb-8">Tambah Event Baru</h1>

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

    <form action="{{ route('organizer.events.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow">
        @csrf

        {{-- Nama Event --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Nama Event <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                   placeholder="Contoh: Soundwave Festival 2025" required>
        </div>

        {{-- Kategori --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Kategori <span class="text-red-500">*</span></label>
            <select name="category_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tipe Event --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Tipe Event <span class="text-red-500">*</span></label>
            <div class="flex gap-6">
                <label class="flex items-center">
                    <input type="radio" name="event_type" value="offline" {{ old('event_type') == 'offline' ? 'checked' : '' }} class="mr-2" required>
                    Offline (Lokasi Fisik)
                </label>
                <label class="flex items-center">
                    <input type="radio" name="event_type" value="online" {{ old('event_type') == 'online' ? 'checked' : '' }} class="mr-2">
                    Online (Virtual)
                </label>
            </div>
        </div>

        {{-- Alamat (muncul kalau offline) --}}
        <div id="locationFields" class="mb-6 hidden">
            <label class="block font-semibold mb-2">Alamat Lengkap</label>
            <input type="text" name="address" value="{{ old('address') }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-3 focus:outline-none focus:ring-2 focus:ring-pink-500"
                   placeholder="Jl. Sudirman No.10">

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-2">Kota</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                           placeholder="Jakarta">
                </div>
                <div>
                    <label class="block font-semibold mb-2">Provinsi</label>
                    <input type="text" name="province" value="{{ old('province') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                           placeholder="DKI Jakarta">
                </div>
            </div>

            <div class="mt-3">
                <label class="block font-semibold mb-2">Kode Pos</label>
                <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                       placeholder="10220">
            </div>
        </div>

        {{-- Tanggal & Waktu --}}
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block font-semibold mb-2">Waktu Mulai <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="start_time" value="{{ old('start_time') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            </div>
            <div>
                <label class="block font-semibold mb-2">Waktu Selesai <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="end_time" value="{{ old('end_time') }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500" required>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="description" rows="5"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500"
                      placeholder="Jelaskan detail event..." required>{{ old('description') }}</textarea>
        </div>

        {{-- Gambar Event --}}
        <div class="mb-6">
            <label class="block font-semibold mb-2">Gambar Event</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500">
            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG. Max: 2MB</p>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-4">
            <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-3 rounded-lg font-semibold">
                Simpan Event
            </button>
            <a href="{{ route('organizer.events') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
    // Show/hide location fields based on event type
    const eventTypeRadios = document.querySelectorAll('input[name="event_type"]');
    const locationFields = document.getElementById('locationFields');

    eventTypeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'offline') {
                locationFields.classList.remove('hidden');
            } else {
                locationFields.classList.add('hidden');
            }
        });
    });

    // Trigger on page load if old value exists
    const selectedType = document.querySelector('input[name="event_type"]:checked');
    if (selectedType && selectedType.value === 'offline') {
        locationFields.classList.remove('hidden');
    }
</script>
@endsection
