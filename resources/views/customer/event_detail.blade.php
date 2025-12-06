@extends(session('role') === 'customer' ? 'components.layout_customer' : 'components.layout')

@section('title', $event->name ?? 'Detail Event')

@section('content')
<div class="container mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- LEFT (2/3 column) --}}
    <div class="lg:col-span-2 space-y-6 text-gray-800">
        {{-- Description --}}
        <div class="bg-white rounded-lg shadow p-6 flex gap-5">
            <img src="{{ asset($event->image_path ?? 'images/event.jpeg') }}" class="w-1/3 h-96 object-cover rounded-lg">
            <div>
                <h1 class="text-2xl font-bold">{{ $event->title }}</h1>
                <div class="text-sm mt-2 text-justify">
                    {!! nl2br(e($event->description)) !!}
                </div>
                <div class="mt-5 text-sm">
                    <strong>Waktu Mulai :</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}
                </div>
                <div class="mt-1 text-sm">
                    <strong>Waktu Berakhir :</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('d M Y') }}
                </div>
                <div class="mt-4 text-sm">
                    <strong>Lokasi : </strong> {{ $event->city ?? 'Online Event' }}
                </div>

            </div>
        </div>

        {{-- Tickets list (memanjang) --}}
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-semibold mb-4">Daftar Tiket</h2>

            @foreach($tickets as $ticket)
                <div class="border rounded-md p-4 mb-4 flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold">{{ $ticket->name }}</h3>
                            <span class="text-sm text-gray-500">
                                @if($ticket->status === 'available')
                                    <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-600">Available</span>
                                @elseif($ticket->status === 'coming_soon')
                                    <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-600">Coming Soon</span>
                                @else
                                    <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-600">Sold Out</span>
                                @endif
                            </span>
                        </div>

                        <div class="mt-2 text-lg font-bold">Rp{{ number_format($ticket->price,0,',','.') }}</div>
                        <div class="text-sm text-gray-500 mt-1">
                            Pembelian minimal {{ $ticket->min_purchase }} — maksimal {{ $ticket->max_purchase }} tiket
                        </div>
                        @if($ticket->note)
                            <div class="text-sm text-gray-600 mt-2">{{ $ticket->note }}</div>
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    {{-- RIGHT (form pemesanan) --}}
    <div class="space-y-4">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-2xl font-bold mb-4 text-center">Form Pemesanan</h3>
            @if(session('error'))
                <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-center">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form id="orderForm" method="POST" onsubmit="event.preventDefault();">
                @csrf
                @foreach($tickets as $ticket)
                    <div class="mb-3 flex items-center justify-between">
                        <div>
                            <div class="font-medium">{{ $ticket->name }}</div>
                            <div class="text-sm text-gray-500">Rp{{ number_format($ticket->price,0,',','.') }}</div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($ticket->status !== 'available')
                                <div class="text-sm text-gray-400">Tidak tersedia</div>
                                <input type="hidden" name="qty[{{ $ticket->id }}]" value="0">
                            @else
                            @php
                                $selected = $cartQty[$ticket->id] ?? 0;

                                // Jika qty sebelumnya > max_purchase (misal EO turunkan max), tetap aman
                                if ($selected > $ticket->max_purchase) {
                                    $selected = $ticket->max_purchase;
                                }
                            @endphp

                            <select name="qty[{{ $ticket->id }}]" class="qty-select" data-price="{{ $ticket->price }}">
                                @for($i = 0; $i <= $ticket->max_purchase; $i++)
                                    <option value="{{ $i }}" {{ $selected == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>

                            @endif
                        </div>
                    </div>
                @endforeach

                <div class="border-t mt-4 pt-3">
                    <div class="flex justify-between items-center mb-2">
                        <div class="text-sm text-gray-600">Total</div>
                        <div id="subtotalText" class="text-lg font-semibold">Rp0</div>
                    </div>

                    <div class="flex gap-3">
                        <button id="btnAddCart" class="flex-1 bg-yellow-600 text-white px-4 py-2 rounded"
                                type="button">Tambah ke Keranjang</button>

                        <button id="btnOrderNow" class="flex-1 bg-pink-600 text-white px-4 py-2 rounded"
                                type="button">Pesan Sekarang</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Organizer card --}}
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset($event->organizer->image_path ?? 'images/logo.png') }}" class="w-16 h-16 rounded-full object-cover">
                <div>
                    <div class="font-semibold">{{ $event->organizer->organization_name ?? $event->organizer->organization_name ?? '-' }}</div>
                    <div class="text-sm text-gray-500">Event Organizer</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal: ask to login --}}
<div id="loginModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40">
    <div class="bg-white rounded-lg p-6 w-96 text-center justify-center items-center">
        <h3 class="text-xl font-semibold mb-3">Silahkan login dulu!!</h3>
        <p class="text-sm text-gray-600 mb-4">Anda perlu login untuk melanjutkan pemesanan atau menambah ke keranjang.</p>
        <div class="flex justify-center gap-2">
            <button onclick="closeModal()" class="px-5 py-2 rounded border">Batal</button>
            <a href="{{ route('login') }}" class="px-5 py-2 bg-pink-600 text-white rounded">Login</a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // loggedIn passed from server
    const loggedIn = {{ session('user_id') ? 'true' : 'false' }};

    // Compute subtotal (sum price*qty)
    function computeSubtotal() {
        let subtotal = 0;
        document.querySelectorAll('.qty-select').forEach(sel => {
            const qty = parseInt(sel.value) || 0;
            const price = parseInt(sel.dataset.price) || 0;
            subtotal += qty * price;
        });
        // format rupiah
        document.getElementById('subtotalText').textContent = formatRupiah(subtotal);
        return subtotal;
    }

    function formatRupiah(num) {
        return 'Rp' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // initial subtotal
    computeSubtotal();

    document.querySelectorAll('.qty-select').forEach(s => {
        s.addEventListener('change', computeSubtotal);
    });

    // modal handling
    function openModal() {
        document.getElementById('loginModal').classList.remove('hidden');
        document.getElementById('loginModal').classList.add('flex');
    }
    function closeModal() {
        document.getElementById('loginModal').classList.add('hidden');
        document.getElementById('loginModal').classList.remove('flex');
    }

    // Add to cart
    document.getElementById('btnAddCart').addEventListener('click', function() {
        if (!loggedIn) {
            openModal();
            return;
        }
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('event.add_to_cart', ['id'=>$event->id]) }}";
        form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">`;
        document.querySelectorAll('select[name^="qty"]').forEach(s => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = s.name;
            input.value = s.value;
            form.appendChild(input);
        });
        document.body.appendChild(form);
        form.submit();
    });

    // Order Now
    document.getElementById('btnOrderNow').addEventListener('click', function() {
        if (!loggedIn) {
            openModal();
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('event.order_now', ['id'=>$event->id]) }}";
        form.innerHTML = `<input type="hidden" name="_token" value="{{ csrf_token() }}">`;
        document.querySelectorAll('select[name^="qty"]').forEach(s => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = s.name;
            input.value = s.value;
            form.appendChild(input);
        });
        document.body.appendChild(form);
        form.submit();
    });

</script>
@endsection
