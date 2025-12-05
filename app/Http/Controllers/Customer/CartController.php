<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Ticket;
use App\Models\Event;

class CartController extends Controller
{
    protected function getCustomerCart()
    {
        $customerId = session('user_id');
        if (!$customerId) {
            return null;
        }

        return Cart::firstOrCreate(['customer_id' => $customerId]);
    }

    public function index()
    {
        $cart = $this->getCustomerCart();
        $groups = collect();

        if ($cart) {
            $items = $cart->cartItems()->with('ticket.event')->get();

            $grouped = $items->groupBy(function($item){
                return $item->ticket->event->id;
            });

            $groups = $grouped->map(function($items, $eventId) {
                $event = $items->first()->ticket->event;
                $total = $items->reduce(function($carry, $it) {
                    return $carry + ($it->ticket->price * $it->quantity);
                }, 0);

                $tickets = $items->map(function($it){
                    return [
                        'cart_item_id' => $it->id,
                        'ticket_id' => $it->ticket->id,
                        'name' => $it->ticket->name,
                        'price' => $it->ticket->price,
                        'qty' => $it->quantity,
                        'subtotal' => $it->ticket->price * $it->quantity,
                    ];
                })->values();

                return [
                    'event_id' => $event->id,
                    'event_title' => $event->title ?? $event->name ?? 'Untitled Event',
                    'event_image' => $event->image_path ?? 'images/event.jpeg',
                    'tickets' => $tickets,
                    'total' => $total,
                ];
            })->values();
        }

        return view('customer.cart', [
            'groups' => $groups
        ]);
    }

    public function addFromEvent(Request $request, $eventId)
    {
        if (!session('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'qty' => 'required|array',
        ]);

        $cart = $this->getCustomerCart();
        $event = Event::findOrFail($eventId);

        foreach ($request->input('qty') as $ticketId => $qty) {
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

            $item = CartItem::firstOrNew([
                'cart_id' => $cart->id,
                'ticket_id' => $ticket->id
            ]);
            $item->quantity = $qty;
            $item->save();
        }

        return redirect()->route('customer.cart')->with('success', 'Tiket berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::findOrFail($id);
        $ticket = $item->ticket;

        if ($request->quantity < $ticket->min_purchase || $request->quantity > $ticket->max_purchase) {
            return back()->with('error', "Jumlah harus antara {$ticket->min_purchase} dan {$ticket->max_purchase}.");
        }

        $item->quantity = $request->quantity;
        $item->save();

        return back()->with('success', 'Jumlah tiket diperbarui.');
    }

    public function deleteEvent(Request $request, $eventId)
    {
        $cart = $this->getCustomerCart();
        if (!$cart) {
            return back()->with('error', 'Keranjang kosong.');
        }

        $items = $cart->cartItems()->whereHas('ticket', function($q) use ($eventId) {
            $q->where('event_id', $eventId);
        })->get();

        if ($items->count() === 0) {
            return back()->with('error', 'Tidak ada item untuk event ini di keranjang.');
        }

        foreach ($items as $it) $it->delete();

        return back()->with('success', 'Semua tiket untuk event telah dihapus dari keranjang.');
    }

    public function detail($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        $tickets = $event->tickets;

        // Ambil cart customer (jika login)
        $customerId = session('user_id');
        $cartQty = [];

        if ($customerId) {
            $cart = Cart::where('customer_id', $customerId)->first();

            if ($cart) {
                foreach ($cart->cartItems as $item) {
                    // hanya ambil tiket yang berasal dari event ini
                    if ($item->ticket->event_id == $id) {
                        $cartQty[$item->ticket_id] = $item->quantity;
                    }
                }
            }
        }

        return view('customer.event_detail', compact('event', 'tickets', 'cartQty'));
    }
}
