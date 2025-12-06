<?php
// ============================================
// FILE 5: resources/views/organizer/orders/report.blade.php - COMPLETE FIXED
// ============================================
?>
@extends('components.layout_organizer')

@section('title', 'Laporan Penjualan')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Laporan & Statistik Penjualan</h1>
            <p class="text-gray-600 mt-1">Analisis performa penjualan tiket event Anda</p>
        </div>
        <a href="{{ route('organizer.orders') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
            ← Kembali
        </a>
    </div>

    {{-- Top 5 Event Terlaris --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Top 5 Event Terlaris</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Ranking</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Nama Event</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Tiket Terjual</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($topEvents as $index => $event)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="text-2xl font-bold text-gray-300">#{{ $index + 1 }}</span>
                            </td>
                            <td class="px-4 py-3 font-medium">{{ $event->title }}</td>
                            <td class="px-4 py-3 text-right font-bold text-blue-600">{{ $event->total_tickets }} tiket</td>
                            <td class="px-4 py-3 text-right font-bold text-green-600">Rp{{ number_format($event->total_revenue, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada data penjualan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Grafik Penjualan Per Event --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">Pendapatan Per Event</h2>
        <div class="space-y-3">
            @php
                $maxRevenue = $eventSales->max('total') ?: 1;
            @endphp
            @forelse($eventSales as $event)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium">{{ $event->title }}</span>
                        <span class="text-sm font-bold text-purple-600">Rp{{ number_format($event->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-4 rounded-full"
                             style="width: {{ ($event->total / $maxRevenue) * 100 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">Belum ada data penjualan</p>
            @endforelse
        </div>
    </div>

    {{-- Grafik Penjualan Bulanan --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold mb-4">Tren Penjualan 6 Bulan Terakhir</h2>
        <div class="space-y-3">
            @php
                $maxMonthlySales = $monthlySales->max('total') ?: 1;
                $months = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            @endphp
            @forelse($monthlySales as $sale)
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium">{{ $months[$sale->month] }} {{ $sale->year }}</span>
                        <span class="text-sm font-bold text-green-600">Rp{{ number_format($sale->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-green-500 to-blue-500 h-4 rounded-full"
                             style="width: {{ ($sale->total / $maxMonthlySales) * 100 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-8">Belum ada data penjualan bulanan</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
