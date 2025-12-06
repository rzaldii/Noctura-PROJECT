<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class EventDetailController extends Controller
{
    // Tampilkan halaman detail event
    public function show($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        $tickets = $event->tickets;

        // ==== PRESELECT QTY (ini yang kamu tambahkan) ====
        $cartQuantities = [];
        if (session('user_id')) {
            $cart = \App\Models\Cart::where('customer_id', session('user_id'))->first();
            if ($cart) {
                $cartItems = $cart->cartItems()->whereHas('ticket', function($q) use ($event) {
                    $q->where('event_id', $event->id);
                })->get();
                foreach ($cartItems as $ci) {
                    $cartQuantities[$ci->ticket_id] = $ci->quantity;
                }
            }
        }

        return view('customer.event_detail', compact('event','tickets','cartQuantities'));
    }

    // Tambah ke keranjang
    public function addToCart(Request $request, $id)
    {
        // jika belum login, redirect ke login (secara backend)
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk menambah ke keranjang.');
        }

        $event = Event::findOrFail($id);

        // validate incoming qtys: expect input name format qty[<ticket_id>]
        $data = $request->input('qty', []); // array ticket_id => qty
        if (!is_array($data) || count($data) == 0) {
            return back()->with('error', 'Tidak ada tiket dipilih.');
        }

        // Filter only positive quantities
        $items = [];
        foreach ($data as $ticketId => $qty) {
            $qty = intval($qty);
            if ($qty <= 0) continue;
            $ticket = Ticket::find($ticketId);
            if (!$ticket) continue;
            // check ticket belongs to this event
            if ($ticket->event_id != $event->id) continue;
            // check status
            if ($ticket->status !== 'available') {
                return back()->with('error', "Jenis tiket \"{$ticket->name}\" tidak tersedia untuk dibeli.");
            }
            // check min/max
            if ($qty < $ticket->min_purchase || $qty > $ticket->max_purchase) {
                return back()->with('error', "Jumlah untuk \"{$ticket->name}\" harus antara {$ticket->min_purchase} sampai {$ticket->max_purchase}.");
            }
            $items[] = ['ticket' => $ticket, 'qty' => $qty];
        }

        if (count($items) === 0) {
            return back()->with('error', 'Silakan pilih jumlah tiket minimal 1.');
        }

        // Insert into carts & cart_items
        $customerId = session('user_id');

        // get or create cart for user
        $cart = Cart::firstOrCreate(
            ['customer_id' => $customerId],
            ['created_at' => now(), 'updated_at' => now()]
        );

        foreach ($items as $it) {
            $ticket = $it['ticket'];
            $qty = $it['qty'];

            // if existing cart item for this ticket -> increment qty else create
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('ticket_id', $ticket->id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $qty;
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id' => $cart->id,
                    'ticket_id' => $ticket->id,
                    'quantity' => $qty,
                    'unit_price' => $ticket->price,
                ]);
            }
        }

        return redirect()->route('customer.cart')->with('success', 'Tiket berhasil ditambahkan ke keranjang.');
    }

    // Pesan sekarang (simpan ke session checkout lalu redirect ke halaman checkout)
    public function orderNow(Request $request, $id)
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk memesan tiket.');
        }

        $event = Event::findOrFail($id);
        $data = $request->input('qty', []);
        $items = [];
        foreach ($data as $ticketId => $qty) {
            $qty = intval($qty);
            if ($qty <= 0) continue;
            $ticket = Ticket::find($ticketId);
            if (!$ticket) continue;
            if ($ticket->event_id != $event->id) continue;
            if ($ticket->status !== 'available') {
                return back()->with('error', "Jenis tiket \"{$ticket->name}\" tidak tersedia.");
            }
            if ($qty < $ticket->min_purchase || $qty > $ticket->max_purchase) {
                return back()->with('error', "Jumlah untuk \"{$ticket->name}\" harus antara {$ticket->min_purchase} sampai {$ticket->max_purchase}.");
            }
            $items[] = [
                'ticket_id' => $ticket->id,
                'name' => $ticket->name,
                'qty' => $qty,
                'unit_price' => $ticket->price,
                'subtotal' => $ticket->price * $qty,
            ];
        }

        if (count($items) === 0) {
            return back()->with('error', 'Silakan pilih minimal 1 tiket untuk memesan.');
        }

        // Save checkout data into session (temporary)
        session(['checkout' => [
            'event_id' => $event->id,
            'items' => $items,
            'total' => array_sum(array_column($items,'subtotal'))
        ]]);

        return back()->with('order_success', true);
    }

    public function detail($id)
    {
        $event = Event::with('tickets')->findOrFail($id);

        $tickets = $event->tickets;

        // Ambil cart customer (kalau ada)
        $customerId = session('user_id');
        $cart = Cart::where('customer_id', $customerId)->first();

        // Ambil qty per ticket
        $cartQty = [];
        if ($cart) {
            foreach ($cart->cartItems as $item) {
                $cartQty[$item->ticket_id] = $item->quantity;
            }
        }

        return view('customer.event_detail', compact('event','tickets','cartQty'));
    }
}
