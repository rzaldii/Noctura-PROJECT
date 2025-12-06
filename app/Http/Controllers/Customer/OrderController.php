<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function orderNow(Request $request, $eventId)
    {
        session(['order_preview' => [
            'event_id' => $eventId,
            'tickets'  => $request->qty
        ]]);

        return redirect()->route('customer.order.preview');
    }

    public function checkoutShow($eventId)
    {
        $customerId = session('user_id');

        // Ambil keranjang customer
        $cart = Cart::where('customer_id', $customerId)->first();
        if (!$cart) {
            return redirect()->route('customer.cart')->with('error', 'Keranjang kosong.');
        }

        // Ambil item khusus event ini
        $items = $cart->cartItems()
            ->whereHas('ticket', fn($q) => $q->where('event_id', $eventId))
            ->with('ticket.event')
            ->get();

        if ($items->count() === 0) {
            return redirect()->route('customer.cart')->with('error', 'Tidak ada tiket untuk event ini.');
        }

        // Ambil event
        $event = $items->first()->ticket->event;

        // Hitung total
        $total = $items->sum(fn($it) => $it->ticket->price * $it->quantity);

        // Data customer
        $customer = auth()->user() ?? \App\Models\Customer::find($customerId);

        return view('customer.checkout', compact('event','items','total','customer'));
    }

    public function checkoutSubmit(Request $request, $eventId)
    {
        $customerId = session('user_id');

        $request->validate([
            'payment_proof' => 'required|image|max:10240' // 10MB
        ]);

        $cart = Cart::where('customer_id', $customerId)->first();
        if (!$cart) return back()->with('error','Keranjang kosong.');

        $items = $cart->cartItems()
            ->whereHas('ticket', fn($q)=>$q->where('event_id',$eventId))
            ->with('ticket')
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error','Tidak ada tiket untuk event ini.');
        }

        // hitung total
        $total = $items->sum(fn($i)=>$i->ticket->price * $i->quantity);

        DB::beginTransaction();
        try {
            // simpan bukti pembayaran
            $path = $request->file('payment_proof')->store('payments','public');

            // buat order
            $order = Order::create([
                'customer_id' => $customerId,
                'total_amount' => $total,
                'status' => 'pending',
                'payment_proof' => $path,
                'payment_proof_uploaded_at' => now()
            ]);

            // insert order_details + issued tickets
            foreach ($items as $it) {

                // OrderDetail
                $detail = OrderDetail::create([
                    'order_id' => $order->id,
                    'ticket_id' => $it->ticket->id,
                    'quantity' => $it->quantity,
                    'unit_price' => $it->ticket->price,
                    'subtotal' => $it->ticket->price * $it->quantity
                ]);

                // kurangi stok tiket
                $it->ticket->stock -= $it->quantity;
                $it->ticket->sold += $it->quantity;
                $it->ticket->save();
            }

            // hapus item keranjang event ini
            CartItem::where('cart_id', $cart->id)
                ->whereIn('id', $items->pluck('id'))
                ->delete();

            DB::commit();

            // tampilkan modal sukses
            return redirect() ->route('customer.orders')
            ->with('success', 'Berhasil membuat pesanan!! Mohon tunggu verifikasi dari event organizer.');


        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error','Gagal membuat pesanan.');
        }
    }

    public function history()
    {
        $customerId = session('user_id');

        $orders = Order::where('customer_id', $customerId)
            ->with('orderDetails.tickets.event')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.orders_history', compact('orders'));
    }

    public function detail($orderId)
    {
        $customerId = session('user_id');

        $order = Order::where('customer_id', $customerId)
            ->where('id', $orderId)
            ->with('orderDetails.tickets.event')
            ->firstOrFail();

        return view('customer.orders_detail', compact('order'));
    }

    public function downloadTicket($orderId)
    {
        $customerId = session('user_id');

        $order = Order::where('customer_id', $customerId)
            ->where('id', $orderId)
            ->with('orderDetails.tickets.event')
            ->firstOrFail();

        $orderDetail = OrderDetail::where('order_id', $orderId)->first();
        $issued = $orderDetail->issuedTickets->first();

        if ($order->status !== 'approved') {
            return back()->with('error', 'Tiket hanya bisa diunduh setelah pesanan disetujui.');
        }

        $pdf = Pdf::loadView('customer.ticket_pdf', [
            'orderDetail' => $orderDetail,
            'issuedTicket' => $issued
        ]);

        return $pdf->download("tiket-order-$orderId.pdf");
    }
}
