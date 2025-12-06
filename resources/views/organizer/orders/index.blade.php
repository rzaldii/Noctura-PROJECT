@extends('components.layout_organizer')

@section('title', 'Kelola Pemesanan')

@section('content')
<div class="max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Kelola Pemesanan</h1>
        <p class="text-gray-600 mt-1">Pantau dan kelola semua pemesanan tiket event Anda</p>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    {{-- Statistik Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-1">Total Pesanan</div>
            <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-1">Pending</div>
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-1">Lunas</div>
            <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-1">Dibatalkan</div>
            <div class="text-2xl font-bold text-red-600">{{ $stats['cancelled'] }}</div>
        </div>

        <div class="bg-white p-5 rounded-lg shadow">
            <div class="text-gray-500 text-sm mb-1">Total Pendapatan</div>
            <div class="text-2xl font-bold text-purple-600">Rp{{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Filter & Actions --}}
    <div class="bg-white p-4 rounded-lg shadow mb-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex gap-2">
                <a href="{{ route('organizer.orders', ['status' => 'all']) }}"
                   class="px-4 py-2 rounded {{ $statusFilter === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Semua
                </a>
                <a href="{{ route('organizer.orders', ['status' => 'pending']) }}"
                   class="px-4 py-2 rounded {{ $statusFilter === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Pending
                </a>
                <a href="{{ route('organizer.orders', ['status' => 'approved']) }}"
                   class="px-4 py-2 rounded {{ $statusFilter === 'approved' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Lunas
                </a>
                <a href="{{ route('organizer.orders', ['status' => 'cancelled']) }}"
                   class="px-4 py-2 rounded {{ $statusFilter === 'cancelled' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    Dibatalkan
                </a>
            </div>

            <a href="{{ route('organizer.orders.report') }}"
               class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                📊 Lihat Laporan
            </a>
        </div>
    </div>

    {{-- Tabel Pesanan --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">ID Order</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Customer</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Event</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Total Tiket</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Total Bayar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm font-mono">#{{ $order->id }}</td>
                            <td class="px-4 py-3 text-sm">
                                <div class="font-medium">{{ $order->customer->fullname }}</div>
                                <div class="text-gray-500 text-xs">{{ $order->customer->email }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                @php
                                    $events = $order->orderDetails->pluck('tickets.event')->unique('id');
                                @endphp
                                @foreach($events as $event)
                                    <div class="text-sm">{{ $event->title }}</div>
                                @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm font-medium">
                                {{ $order->orderDetails->sum('quantity') }} tiket
                            </td>
                            <td class="px-4 py-3 text-sm font-bold text-purple-600">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                {!! $order->status_badge !!}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $order->created_at->format('d M Y') }}<br>
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('organizer.orders.show', $order->id) }}"
                                       class="bg-blue-500 text-white px-3 py-1 rounded text-xs hover:bg-blue-600">
                                        Detail
                                    </a>

                                    @if($order->status === 'pending')
                                        <form action="{{ route('organizer.orders.approve', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="bg-green-500 text-white px-3 py-1 rounded text-xs hover:bg-green-600"
                                                    onclick="return confirm('Approve pesanan ini?')">
                                                Approve
                                            </button>
                                        </form>

                                        <form action="{{ route('organizer.orders.cancel', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600"
                                                    onclick="return confirm('Batalkan pesanan ini?')">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                Belum ada pesanan untuk event Anda
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-4 py-3 border-t">
            {{ $orders->links() }}
        </div>
    </div>

</div>
@endsection
