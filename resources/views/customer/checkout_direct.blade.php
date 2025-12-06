@extends('components.layout_customer')
@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow p-8 rounded-lg mt-6">

    <h1 class="text-3xl font-bold text-center mb-8">Konfirmasi Pembayaran</h1>

    {{-- EVENT --}}
    <div class="flex gap-6 mb-8">
        <img src="{{ asset($event->image_path ?? 'images/event.jpeg') }}"
             class="w-48 h-32 object-cover rounded">

        <div>
            <h2 class="text-xl font-semibold">{{ $event->title }}</h2>
            <p class="text-gray-600">{{ $event->city }}</p>

            <p class="text-sm mt-2">
                {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse($event->end_time)->format('d M Y') }}
            </p>
        </div>
    </div>

    {{-- CUSTOMER --}}
    <div class="mb-8">
        <h3 class="font-semibold mb-2">Data Customer</h3>
        <p><strong>Nama:</strong> {{ $customer->full_name }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
    </div>

    {{-- ITEMS --}}
    <div class="mb-8">
        <h3 class="font-semibold mb-3">Detail Tiket</h3>

        @foreach($items as $it)
            <div class="border-b pb-2 mb-2 text-sm flex justify-between">
                <span>{{ $it['name'] }} — {{ $it['qty'] }} × Rp{{ number_format($it['unit_price'], 0, ',', '.') }}</span>
                <strong>Rp{{ number_format($it['subtotal'], 0, ',', '.') }}</strong>
            </div>
        @endforeach

        <div class="text-right text-lg mt-4 font-bold text-pink-700">
            Total: Rp{{ number_format($total, 0, ',', '.') }}
        </div>
    </div>

    {{-- QRIS --}}
    <div class="my-8 text-center">
        <h3 class="font-semibold mb-2">Scan QRIS untuk pembayaran</h3>
        <img src="{{ asset('images/qris.jpeg') }}" class="w-64 mx-auto shadow-lg rounded" alt="QRIS">
    </div>

    {{-- FORM --}}
    <form action="{{ route('customer.checkout.direct.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label class="font-semibold block mb-1">Upload Bukti Pembayaran</label>
            <input type="file" name="payment_proof" accept="image/*"
                   class="border rounded p-2 w-full" required>
            <p class="text-xs text-gray-500 mt-1">Max 10MB</p>
        </div>

        <button type="submit"
            class="w-full bg-pink-700 text-white py-3 rounded-lg font-semibold hover:bg-pink-800">
            Kirim Bukti Pembayaran
        </button>
    </form>
</div>
@endsection
