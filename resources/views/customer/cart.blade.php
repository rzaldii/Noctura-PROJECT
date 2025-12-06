@extends('components.layout_customer')
@section('title','Keranjang')

@section('content')
<h1 class="text-4xl font-bold text-center pb-6">Keranjang Tiket</h1>
@if (session('success'))
    <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-6 text-center">
        {{ session('success') }}
    </div>
@endif
<div class="max-w-6xl mx-auto mt-4">
    @if($groups->isEmpty())
        <p class="text-center text-gray-600">Keranjang kosong. <a href="{{ route('customer.dashboard') }}" class="text-blue-600 underline">Cari event</a></p>
    @else
        <div class="space-y-6">
            @foreach($groups as $group)
            <div class="bg-white shadow p-4 rounded-lg mb-4">
                <div class="flex items-start gap-6">

                    {{-- BAGIAN 1: gambar + judul + total --}}
                    <div class="w-1/3 flex gap-4 items-center">
                        <img src="{{ asset($group['event_image']) }}" class="h-20 w-28 object-cover rounded">
                        <div>
                            <div class="font-semibold text-lg">{{ $group['event_title'] }}</div>
                            <div class="text-sm text-gray-500">Total</div>
                            <div class="text-xl font-bold text-pink-600">Rp{{ number_format($group['total'],0,',','.') }}</div>
                        </div>
                    </div>

                    {{-- BAGIAN 2: detail tiket (agak ke atas) --}}
                    <div class="w-1/3">
                        <div class="space-y-2 text-sm">
                            @foreach($group['tickets'] as $t)
                                <div>
                                    <div class="flex justify-between">
                                        <div class="font-medium">{{ $t['name'] }}</div>
                                        <div>Rp{{ number_format($t['price'],0,',','.') }} × {{ $t['qty'] }}</div>
                                    </div>
                                    <div class="text-xs text-gray-500">Subtotal: Rp{{ number_format($t['subtotal'],0,',','.') }}</div>
                                </div>
                                @if (!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- BAGIAN 3: tombol (horizontal) --}}
                    <div class="w-1/3 flex items-center justify-end">
                        <div class="flex gap-2">
                            {{-- Edit --}}
                            <a href="{{ route('event.detail', $group['event_id']) }}"
                               class="px-3 py-2 bg-yellow-500 text-white text-sm rounded">
                                Edit
                            </a>

                            {{-- Hapus --}}
                            <button onclick="openDeleteModal({{ $group['event_id'] }})"
                                    class="px-3 py-2 bg-red-600 text-white text-sm rounded">
                                Hapus
                            </button>

                            {{-- Checkout --}}
                            <a href="{{ route('checkout.show', $group['event_id']) }}"
                               class="px-3 py-2 bg-pink-600 text-white text-sm rounded">
                                Checkout
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>

        {{-- Delete modal --}}
        <div id="deleteModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
            <div class="bg-white p-5 rounded-lg w-80">
                <h2 class="font-semibold mb-3">Hapus item?</h2>
                <p class="text-sm mb-4">Apakah Anda yakin ingin menghapus semua tiket untuk event ini dari keranjang?</p>

                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="closeDeleteModal()" class="px-3 py-1 border rounded">
                            Batal
                        </button>
                        <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function openDeleteModal(eventId) {
        // Sesuaikan path sesuai route delete yang kamu pakai:
        document.getElementById('deleteForm').action = "/customer/cart/delete/event/" + eventId;
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection
