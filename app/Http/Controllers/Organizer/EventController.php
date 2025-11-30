<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Tampil semua event milik organizer ini (Manage Event)
    public function index()
    {
        $organizerId = session('user_id');
        $events = Event::where('organizer_id', $organizerId)
            ->orderBy('start_time', 'desc')
            ->get();

        return view('organizer.events.index', compact('events'));
    }

    // Form tambah event baru
    public function create()
    {
        $categories = Category::all();
        return view('organizer.events.create', compact('categories'));
    }

    // Simpan event baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'event_type' => 'required|in:online,offline',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|image|max:2048',
            'address' => 'required_if:event_type,offline',
            'city' => 'required_if:event_type,offline',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        Event::create([
            'organizer_id' => session('user_id'),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'event_type' => $request->event_type,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'image_path' => $imagePath,
            'status' => 'active',
        ]);

        return redirect()->route('organizer.events')->with('success', 'Event berhasil ditambahkan!');
    }

    // Form edit event
    public function edit($id)
    {
        $event = Event::where('id', $id)
            ->where('organizer_id', session('user_id'))
            ->firstOrFail();
        $categories = Category::all();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

    // Update event
    public function update(Request $request, $id)
    {
        $event = Event::where('id', $id)
            ->where('organizer_id', session('user_id'))
            ->firstOrFail();

        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required',
            'event_type' => 'required|in:online,offline',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $event->image_path;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($imagePath && file_exists(public_path($imagePath))) {
                unlink(public_path($imagePath));
            }
            $imagePath = $request->file('image')->store('events', 'public');
            $imagePath = 'storage/' . $imagePath;
        }

        $event->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'event_type' => $request->event_type,
            'address' => $request->address,
            'city' => $request->city,
            'province' => $request->province,
            'postal_code' => $request->postal_code,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('organizer.events')->with('success', 'Event berhasil diupdate!');
    }

    // Hapus event
    public function destroy($id)
    {
        $event = Event::where('id', $id)
            ->where('organizer_id', session('user_id'))
            ->firstOrFail();

        // Hapus gambar jika ada
        if ($event->image_path && file_exists(public_path($event->image_path))) {
            unlink(public_path($event->image_path));
        }

        $event->delete();

        return redirect()->route('organizer.events')->with('success', 'Event berhasil dihapus!');
    }
}
