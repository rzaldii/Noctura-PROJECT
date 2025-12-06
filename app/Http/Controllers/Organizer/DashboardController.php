<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $organizerId = session('user_id');

        if (!$organizerId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!session('user')) {
            $organizer = DB::table('organizers')->where('id', $organizerId)->first();
            if ($organizer) {
                session([
                    'user' => [
                        'fullname' => $organizer->organization_name ?? $organizer->username,
                        'image' => $organizer->image_path ?? 'images/default-avatar.png',
                        'email' => $organizer->email,
                    ]
                ]);
            }
        }

        // 1. Total Event
        $totalEvents = Event::where('organizer_id', $organizerId)->count();

        // 2. Total Tiket Terjual
        $totalTicketsSold = OrderDetail::whereHas('tickets', function ($q) use ($organizerId) {
            $q->whereHas('event', function ($q2) use ($organizerId) {
                $q2->where('organizer_id', $organizerId);
            });
        })->sum('quantity');

        // 3. Total Pelanggan
        $totalCustomers = Order::whereHas('orderDetails', function ($q) use ($organizerId) {
            $q->whereHas('tickets', function ($q2) use ($organizerId) {
                $q2->whereHas('event', function ($q3) use ($organizerId) {
                    $q3->where('organizer_id', $organizerId);
                });
            });
        })->distinct('customer_id')->count('customer_id');

        // 4. Total Pendapatan
        $totalRevenue = OrderDetail::whereHas('tickets', function ($q) use ($organizerId) {
            $q->whereHas('event', function ($q2) use ($organizerId) {
                $q2->where('organizer_id', $organizerId);
            });
        })->sum('subtotal');

        $events = Event::where('organizer_id', $organizerId)
            ->with(['tickets.orderDetails'])
            ->orderBy('start_time', 'desc')
            ->get()
            ->map(function ($event) {
                $ticketsSoldPerEvent = $event->tickets->sum('sold');

                $revenuePerEvent = OrderDetail::whereIn('ticket_id', $event->tickets->pluck('id'))
                    ->sum('subtotal');

                $event->tickets_sold = $ticketsSoldPerEvent;
                $event->revenue = $revenuePerEvent;

                return $event;
            });

        return view('organizer.dashboard', compact(
            'totalEvents',
            'totalTicketsSold',
            'totalCustomers',
            'totalRevenue',
            'events'
        ));
    }
}
