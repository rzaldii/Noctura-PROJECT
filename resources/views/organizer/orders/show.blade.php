@extends('components.layout_organizer')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap pemesanan tiket</p>
        </div>
        <a href="{{ route('organizer.orders') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            ← Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        {{-- Status Card --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-2">Status Pembayaran</div>
            <div>{!! $order->status_badge !!}</div>
        </div>

        {{-- Total Amount --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-2">Total Pembayaran</div>
            <div class="text-2xl font-bold text-purple-600">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</div>
        </div>

        {{-- Order Date --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-2">Tanggal Pemesanan</div>
            <div class="text-lg font-semibold">{{ $order->created_at->format('d M Y, H:i') }}</div>
        </div>
    </div>

    {{-- Customer Info --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Informasi Customer</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="text-gray-500 text-sm">Nama Lengkap</div>
                <div class="font-medium">{{ $order->customer->full_name }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Email</div>
                <div class="font-medium">{{ $order->customer->email }}</div>
            </div>
            <div>
                <div class="text-gray-500 text-sm">Username</div>
                <div class="font-medium">{{ $order->customer->username ?? '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Payment Proof --}}
    @if($order->payment_proof)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Bukti Pembayaran</h2>
        <div class="flex items-center gap-4">
            <img src="{{ asset('storage/' . $order->payment_proof) }}"
                 alt="Bukti Pembayaran"
                 class="w-64 h-auto rounded border shadow-lg cursor-pointer"
                 onclick="window.open(this.src, '_blank')">
            <div class="text-sm text-gray-600">
                <p>Klik gambar untuk memperbesar</p>
                <p class="mt-2">Upload: {{ $order->payment_proof_uploaded_at ? $order->payment_proof_uploaded_at->format('d M Y, H:i') : '-' }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Order Details --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold">Detail Tiket</h2>
        </div>

        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Event</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Jenis Tiket</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Harga Satuan</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($order->orderDetails as $detail)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $detail->ticket->event->title }}</div>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($detail->ticket->event->start_time)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                                {{ $detail->ticket->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center font-medium">{{ $detail->quantity }}</td>
                        <td class="px-6 py-4 text-right">Rp{{ number_format($detail->unit_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-right font-bold">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach

                <tr class="bg-gray-50">
                    <td colspan="4" class="px-6 py-4 text-right font-bold text-lg">TOTAL</td>
                    <td class="px-6 py-4 text-right font-bold text-lg text-purple-600">
                        Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- Actions --}}
    @if($order->status === 'pending')
        <div class="mt-6 flex gap-3">
            <form action="{{ route('organizer.orders.approve', $order->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-semibold"
                        onclick="return confirm('Approve pesanan ini? Stok tiket akan berkurang.')">
                    ✓ Approve Pesanan
                </button>
            </form>

            <form action="{{ route('organizer.orders.cancel', $order->id) }}" method="POST" class="flex-1">
                @csrf
                <button type="submit"
                        class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 font-semibold"
                        onclick="return confirm('Batalkan pesanan ini?')">
                    ✕ Batalkan Pesanan
                </button>
            </form>
        </div>
    @endif

</div>
@endsection
