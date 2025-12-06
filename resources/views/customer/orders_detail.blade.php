@extends('components.layout_customer')
@section('title','Detail Pemesanan')

@section('content')
<h1 class="text-4xl font-bold text-center mb-8">Detail Pemesanan</h1>

<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">

    @php
        $event = $order->orderDetails->first()->tickets->event;
    @endphp

    {{-- EVENT --}}
    <div class="flex gap-6 mb-8">
        <img src="{{ asset($event->image_path) }}" class="w-48 h-32 object-cover rounded">
        <div>
            <h2 class="text-xl font-semibold">{{ $event->title }}</h2>
            <p>{{ $event->city }}</p>
            <p class="text-sm mt-1 mb-2">
                {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse($event->end_time)->format('d M Y') }}
            </p>

            @if($order->status=='pending')
                <span class="text-sm px-2 py-1 rounded bg-yellow-100 text-yellow-700">Menunggu Konfirmasi</span>
            @elseif($order->status=='approved')
                <span class="text-sm px-2 py-1 rounded bg-green-100 text-green-700">Disetujui</span>
            @else
                <span class="text-sm px-2 py-1 rounded bg-red-100 text-red-700">Ditolak</span>
            @endif

        </div>
    </div>

    {{-- DETAILS --}}
    <h3 class="font-semibold mb-2">Tiket Dibeli:</h3>
    @foreach($order->orderDetails as $det)
        <div class="border-b pb-2 mb-2 flex justify-between">
            <span>{{ $det->tickets->name }} — {{ $det->quantity }} × Rp{{ number_format($det->unit_price,0,',','.') }}</span>
            <strong>Rp{{ number_format($det->subtotal,0,',','.') }}</strong>
        </div>
    @endforeach

    <div class="text-right text-xl font-bold mt-4 text-pink-700">
        Total: Rp{{ number_format($order->total_amount,0,',','.') }}
    </div>

    @if($order->status == 'approved')
    <div class="text-center mt-6">
        <a href="{{ route('customer.orders.download', $order->id) }}"
           class="px-4 py-2 bg-pink-700 text-white rounded-lg">
           Download Tiket
        </a>
    </div>
    @endif

</div>
@endsection
