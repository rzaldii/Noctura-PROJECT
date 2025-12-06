@extends('components.layout_customer')
@section('title','Riwayat Pemesanan')

@section('content')
<h1 class="text-4xl font-bold text-center mb-8">Riwayat Pemesanan</h1>
@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-6 text-center">
        {{ session('success') }}
    </div>
@endif
<div class="max-w-5xl mx-auto">
    @if($orders->isEmpty())
        <p class="text-center text-gray-500">Belum ada pemesanan.</p>
    @else
        <div class="space-y-5">
            @foreach($orders as $order)
                @php
                    $event = $order->orderDetails->first()->tickets->event;
                @endphp

                <div class="bg-white shadow rounded-lg p-4 flex gap-6 items-center">

                    {{-- IMAGE --}}
                    <img src="{{ asset($event->image_path) }}" class="w-32 h-20 object-cover rounded">

                    {{-- MIDDLE --}}
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold">{{ $event->title }}</h2>

                        <p class="text-sm text-gray-600 mb-1">
                            Rp{{ number_format($order->total_amount,0,',','.') }}
                        </p>

                        @if($order->status=='pending')
                            <span class="text-sm px-2 py-1 rounded bg-yellow-100 text-yellow-700">Menunggu Konfirmasi</span>
                        @elseif($order->status=='approved')
                            <span class="text-sm px-2 py-1 rounded bg-green-100 text-green-700">Disetujui</span>
                        @else
                            <span class="text-sm px-2 py-1 rounded bg-red-100 text-red-700">Ditolak</span>
                        @endif
                    </div>

                    {{-- RIGHT BUTTON --}}
                    <div class="flex gap-2">
                        <a href="{{ route('customer.orders.detail', $order->id) }}"
                           class="px-3 py-2 bg-gray-700 text-white text-sm rounded">
                           Lihat Detail
                        </a>

                        @if($order->status == 'approved')
                        <a href="{{ route('customer.orders.download', $order->id) }}"
                           class="px-3 py-2 bg-pink-700 text-white text-sm rounded">
                           Download Tiket
                        </a>
                        @endif
                    </div>

                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
