<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Event;

class TicketController extends Controller
{
    // Tampil semua tiket untuk 1 event
    public function index($eventId)
    {
        $event = Event::where('id', $eventId)
            ->where('organizer_id', session('user_id'))
            ->firstOrFail();

        $tickets = Ticket::where('event_id', $eventId)->get();

        return view('organizer.tickets.index', compact('event', 'tickets'));
    }

    // Form tambah tiket baru
    public function create($eventId)
    {
        $event = Event::where('id', $eventId)
            ->where('organizer_id', session('user_id'))
            ->firstOrFail();

        return view('organizer.tickets.create', compact('event'));
    }

    // Simpan tiket baru
    public function store(Request $request, $eventId)
    {
        $event = Event::where('id', $eventId)
            ->where('organizer_id', session('user_id'))
            ->firstOrFail();

        $request->validate([
            'name' => 'required|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
        ]);

        Ticket::create([
            'event_id' => $eventId,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'sold' => 0,
            'status' => 'available',
            'min_purchase' => $request->min_purchase ?? 1,
            'max_purchase' => $request->max_purchase ?? 10,
        ]);

        return redirect()->route('organizer.tickets.index', $eventId)
            ->with('success', 'Tiket berhasil ditambahkan!');
    }

    // Hapus tiket
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);

        // Cek apakah event milik organizer ini
        $event = Event::where('id', $ticket->event_id)
            ->where('organizer_id', session('user_id'))
            ->firstOrFail();

        $ticket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
    }
}
