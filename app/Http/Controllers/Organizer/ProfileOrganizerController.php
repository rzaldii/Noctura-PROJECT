<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organizer;
use Illuminate\Support\Facades\DB;

class ProfileOrganizerController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $organizer = Organizer::findOrFail($userId);

        // Hitung statistik organizer
        $totalEvents = DB::table('events')->where('organizer_id', $userId)->count();
        $totalTicketsSold = DB::table('order_details')
            ->join('tickets', 'order_details.ticket_id', '=', 'tickets.id')
            ->join('events', 'tickets.event_id', '=', 'events.id')
            ->where('events.organizer_id', $userId)
            ->sum('order_details.quantity');

        return view('organizer.profile', compact('organizer', 'totalEvents', 'totalTicketsSold'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('landing')->with('success', 'Berhasil logout.');
    }
}
