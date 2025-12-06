<?php

namespace App\Http\Controllers\Organizer;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $organizerId = session('user_id');

            if (!$organizerId) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            // Ambil filter status dari request
            $statusFilter = $request->get('status', 'all');

            $query = Order::with(['customer', 'orderDetails.tickets.event'])
                ->whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })
                ->orderBy('created_at', 'desc');

            // Filter berdasarkan status
            if ($statusFilter !== 'all') {
                $query->where('status', $statusFilter);
            }

            $orders = $query->paginate(10);

            // Hitung statistik
            $stats = [
                'total' => Order::whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })->count(),

                'pending' => Order::whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })->where('status', 'pending')->count(),

                'approved' => Order::whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })->where('status', 'approved')->count(),

                'cancelled' => Order::whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })->where('status', 'cancelled')->count(),

                'total_revenue' => Order::whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })->where('status', 'approved')->sum('total_amount'),
            ];

            return view('organizer.orders.index', compact('orders', 'stats', 'statusFilter'));

        } catch (\Exception $e) {
            Log::error('Error in OrderController@index: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->view('errors.custom', [
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $organizerId = session('user_id');

            if (!$organizerId) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            $order = Order::with(['customer', 'orderDetails.tickets.event'])
                ->whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })
                ->findOrFail($id);

            return view('organizer.orders.show', compact('order'));

        } catch (\Exception $e) {
            Log::error('Error in OrderController@show: ' . $e->getMessage());
            return redirect()->route('organizer.orders')->with('error', 'Order tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function approve($id)
    {
        try {
            $organizerId = session('user_id');

            $order = Order::whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })
                ->findOrFail($id);

            if ($order->status !== 'pending') {
                return redirect()->back()->with('error', 'Hanya pesanan dengan status pending yang bisa diapprove.');
            }

            DB::beginTransaction();
            try {
                $order->update(['status' => 'approved']);

                // Update stok tiket (kurangi kuota)
                foreach ($order->orderDetails as $detail) {
                    $ticket = $detail->tickets;
                    $ticket->decrement('quota', $detail->quantity);
                }

                DB::commit();
                return redirect()->back()->with('success', 'Pesanan berhasil diapprove!');
            } catch (\Exception $e) {
                DB::rollback();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Error in OrderController@approve: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel($id)
    {
        try {
            $organizerId = session('user_id');

            $order = Order::whereHas('orderDetails.tickets.event', function($q) use ($organizerId) {
                    $q->where('organizer_id', $organizerId);
                })
                ->findOrFail($id);

            if ($order->status === 'cancelled') {
                return redirect()->back()->with('error', 'Pesanan sudah dibatalkan.');
            }

            if ($order->status === 'approved') {
                return redirect()->back()->with('error', 'Pesanan yang sudah diapprove tidak bisa dibatalkan.');
            }

            $order->update(['status' => 'cancelled']);

            return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');

        } catch (\Exception $e) {
            Log::error('Error in OrderController@cancel: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function report()
    {
        try {
            $organizerId = session('user_id');

            if (!$organizerId) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
            }

            // Data untuk grafik penjualan per event
            $eventSales = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('tickets', 'order_details.ticket_id', '=', 'tickets.id')
                ->join('events', 'tickets.event_id', '=', 'events.id')
                ->where('events.organizer_id', $organizerId)
                ->where('orders.status', 'approved')
                ->select('events.title', DB::raw('SUM(order_details.subtotal) as total'))
                ->groupBy('events.id', 'events.title')
                ->get();

            // Penjualan per bulan (6 bulan terakhir)
            $monthlySales = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('tickets', 'order_details.ticket_id', '=', 'tickets.id')
                ->join('events', 'tickets.event_id', '=', 'events.id')
                ->where('events.organizer_id', $organizerId)
                ->where('orders.status', 'approved')
                ->where('orders.created_at', '>=', now()->subMonths(6))
                ->select(
                    DB::raw('MONTH(orders.created_at) as month'),
                    DB::raw('YEAR(orders.created_at) as year'),
                    DB::raw('SUM(order_details.subtotal) as total')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            // Top 5 event terlaris
            $topEvents = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('tickets', 'order_details.ticket_id', '=', 'tickets.id')
                ->join('events', 'tickets.event_id', '=', 'events.id')
                ->where('events.organizer_id', $organizerId)
                ->where('orders.status', 'approved')
                ->select(
                    'events.title',
                    DB::raw('SUM(order_details.quantity) as total_tickets'),
                    DB::raw('SUM(order_details.subtotal) as total_revenue')
                )
                ->groupBy('events.id', 'events.title')
                ->orderBy('total_tickets', 'desc')
                ->limit(5)
                ->get();

            return view('organizer.orders.report', compact('eventSales', 'monthlySales', 'topEvents'));

        } catch (\Exception $e) {
            Log::error('Error in OrderController@report: ' . $e->getMessage());
            return redirect()->route('organizer.orders')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
