<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class OrderController extends Controller
{
    public function index()
    {
        $organizerId = session('user_id');

        // Ambil orders yang ada tiket dari event organizer ini
        $orders = Order::whereHas('orderDetails', function($q) use ($organizerId) {
            $q->whereHas('tickets', function($q2) use ($organizerId) {
                $q2->whereHas('event', function($q3) use ($organizerId) {
                    $q3->where('organizer_id', $organizerId);
                });
            });
        })->orderBy('created_at', 'desc')->get();

        return view('organizer.orders.index', compact('orders'));
    }
}
