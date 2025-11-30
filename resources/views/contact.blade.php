@extends('components.layout')
@section('title', 'Contact')

@section('content')
<div class="max-w-4xl mx-auto py-16 px-6">

    <!-- Judul Halaman -->
    <h1 class="text-4xl font-semibold text-gray-900 mb-8 text-center">Contact</h1>

    <div id="contact" class="bg-white p-8 rounded-2xl shadow">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Hubungi Kami</h2>

        <p class="text-gray-700 mb-4">
            Jika Anda memiliki pertanyaan seputar kerja sama atau mengalami kendala terkait tiket,
            silakan hubungi kami melalui kontak berikut. Tim kami siap membantu Anda sebaik mungkin.
        </p>

        <div class="space-y-3 text-gray-700">
            <p class="flex items-start gap-2">
                <span class="font-semibold w-32">Alamat:</span>
                <span>
                    Jalan Kalimantan No. 37 – Kampus Tegalboto Kotak POS 159 Jember, Jawa Timur, 68121
                </span>
            </p>

            <p class="flex items-start gap-2">
                <span class="font-semibold w-32">Telepon:</span>
                <span>+62 821-3767-6220</span>
            </p>

            <p class="flex items-start gap-2">
                <span class="font-semibold w-32">Email:</span>
                <span>cs@noctura.co.id</span>
            </p>
        </div>
    </div>
</div>
@endsection
