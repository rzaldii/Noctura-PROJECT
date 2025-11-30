@extends('components.layout_organizer')

@section('title', 'Profil Organizer')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow mt-8 text-center">

    <h2 class="text-4xl font-bold mb-6">Profile Event Organizer</h2>

    {{-- Foto Profil --}}
    <img src="{{ asset($organizer->image_path ?? 'images/default-avatar.png') }}"
         class="w-36 h-36 rounded-full object-cover border mx-auto"
         alt="Logo Organizer">

    {{-- Nama Organisasi --}}
    <div>
        <h1 class="text-2xl font-bold pt-3 pb-2">{{ $organizer->organization_name }}</h1>
        <p class="text-gray-600 italic">{{ $organizer->username }}</p>
    </div>

    {{-- Info Detail --}}
    <div class="space-y-3 text-center mt-6">
        <p><strong>Email:</strong> {{ $organizer->email }}</p>

        @if($organizer->description)
        <p class="text-gray-700 mt-4 px-6">
            <strong>Deskripsi:</strong><br>
            {{ $organizer->description }}
        </p>
        @endif
    </div>

    {{-- Statistik Singkat --}}
    <div class="grid grid-cols-2 gap-4 mt-8 px-12">
        <div class="bg-pink-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Total Event</p>
            <p class="text-3xl font-bold text-pink-600">{{ $totalEvents }}</p>
        </div>
        <div class="bg-blue-50 p-4 rounded-lg">
            <p class="text-sm text-gray-600">Tiket Terjual</p>
            <p class="text-3xl font-bold text-blue-600">{{ $totalTicketsSold }}</p>
        </div>
    </div>

    {{-- Tombol Logout --}}
    <form action="{{ route('organizer.logout') }}" method="POST" class="mt-8">
        @csrf
        <button type="submit"
                class="px-5 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-600">
            Logout
        </button>
    </form>

</div>

@endsection
