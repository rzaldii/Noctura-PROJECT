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

        $events = Event::where('organizer_id', $organizerId)
            ->orderBy('start_time', 'desc')
            ->get();

        return view('organizer.dashboard', compact('events'));
    }
}
