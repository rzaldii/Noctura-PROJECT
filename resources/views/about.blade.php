@extends('components.layout')
@section('title', 'About')

@section('content')
<div class="max-w-4xl mx-auto py-16 px-6">

    <!-- Judul Halaman -->
    <h1 class="text-4xl font-semibold text-gray-900 mb-8 text-center">Apa itu Noctura?</h1>

    <!-- About -->
    <div id="about" class="bg-white p-8 rounded-2xl shadow mb-12">
        {{-- <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tentang Noctura</h2> --}}
        <p class="text-gray-700 leading-relaxed">
            Noctura adalah platform pencarian dan informasi event yang memudahkan pengguna
            menemukan acara menarik, mulai dari seminar, konser, hingga kompetisi besar.
            Kami hadir untuk menghubungkan penyelenggara event dan para peserta melalui pengalaman yang mudah dan cepat.
        </p>

        <p class="text-xl font-medium text-gray-900 mt-6 italic text-center">
            Event Made Simple — Experience Made Better
        </p>
    </div>

    <!-- Keunggulan -->
    <div class="bg-white p-8 rounded-2xl shadow mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Kenapa Harus Noctura?</h2>

        <div class="grid md:grid-cols-2 gap-6">

            <div class="p-5 border rounded-xl shadow-sm bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Kemudahan Pembelian Tiket</h3>
                <p class="text-gray-700 mt-2">
                    Pembelian tiket menjadi lebih cepat dan praktis melalui antarmuka yang sederhana dan nyaman digunakan.
                </p>
            </div>

            <div class="p-5 border rounded-xl shadow-sm bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Pembayaran yang Aman</h3>
                <p class="text-gray-700 mt-2">
                    Semua transaksi dilindungi sistem pembayaran tepercaya sehingga pengguna dapat membeli tiket tanpa khawatir.
                </p>
            </div>

            <div class="p-5 border rounded-xl shadow-sm bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Rekomendasi Event</h3>
                <p class="text-gray-700 mt-2">
                    Temukan event sesuai minat Anda, dari konser hingga kompetisi besar yang relevan dengan preferensi Anda.
                </p>
            </div>

            <div class="p-5 border rounded-xl shadow-sm bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Dashboard Pengelolaan Event</h3>
                <p class="text-gray-700 mt-2">
                    Kelola detail event, pantau penjualan tiket, dan atur data peserta melalui dashboard yang lengkap.
                </p>
            </div>

            <div class="p-5 border rounded-xl shadow-sm bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Laporan & Analitik Real-Time</h3>
                <p class="text-gray-700 mt-2">
                    Dapatkan insight performa event melalui laporan yang membantu pengembangan event berikutnya.
                </p>
            </div>

            <div class="p-5 border rounded-xl shadow-sm bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Promosi Event Lebih Mudah</h3>
                <p class="text-gray-700 mt-2">
                    Publikasikan event dan jangkau lebih banyak peserta melalui platform Noctura dengan mudah.
                </p>
            </div>

        </div>
    </div>

    <!-- Kategori -->
    <div class="bg-white p-8 rounded-2xl shadow mb-12 text-center">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Kategori Event</h2>

        <div class="flex flex-wrap justify-center gap-4">
            @foreach (['Competition','Concert','Performance','Seminar','Training'] as $cat)
                <div class="px-6 py-3 bg-gray-100 border rounded-xl shadow-sm text-gray-800 font-medium">
                    {{ $cat }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- Statistik -->
    <div class="bg-white p-8 rounded-2xl shadow mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Statistik</h2>
        <p class="text-gray-700 text-center mb-6">
            Noctura terus berkembang dan dipercaya oleh berbagai Event Organizer serta ribuan pengguna.
        </p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-2xl font-bold text-gray-900">3000+</p>
                <p class="text-gray-700 text-sm">Tiket Terjual</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">150+</p>
                <p class="text-gray-700 text-sm">Event Organizer</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">200+</p>
                <p class="text-gray-700 text-sm">Event Per Tahun</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">Ratusan</p>
                <p class="text-gray-700 text-sm">Pengguna Baru / Minggu</p>
            </div>
        </div>
    </div>

    <!-- PARTNER SECTION -->
    <div class="bg-white p-8 rounded-2xl shadow mb-12 text-center">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Partner Kami</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @php
                $partners = ['SoundWave Live', 'EduVenture', 'GameVerse'];
            @endphp

            @foreach ($partners as $partner)
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 rounded-full bg-gray-200 border shadow-sm"></div>
                    <p class="mt-3 font-medium text-gray-800">{{ $partner }}</p>
                </div>
            @endforeach

        </div>
    </div>

</div>
@endsection
