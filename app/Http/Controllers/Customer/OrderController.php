<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}

