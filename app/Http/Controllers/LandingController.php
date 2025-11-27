<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Carbon\Carbon;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        // Base query: only active events
        $query = Event::query()->where('status', 'active')
            ->with(['tickets', 'organizer', 'category']);

        // Search by event title
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('title', 'ilike', "%{$q}%"); // using ilike for Postgres case-insensitive
        }

        // Filter: city
        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        // Filter: event_type (online/offline)
        if ($request->filled('event_type')) {
            $query->where('event_type', $request->input('event_type'));
        }

        // Filter: category (filter by category id)
        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        // Filter: time (today, week, month, year)
        if ($request->filled('time')) {
            $time = $request->input('time');
            $now = Carbon::now();

            if ($time === 'today') {
                $query->whereDate('start_time', $now->toDateString());
            } elseif ($time === 'week') {
                $query->whereBetween('start_time', [$now->startOfWeek(), $now->endOfWeek()]);
            } elseif ($time === 'month') {
                $query->whereBetween('start_time', [$now->startOfMonth(), $now->endOfMonth()]);
            } elseif ($time === 'year') {
                $query->whereBetween('start_time', [$now->startOfYear(), $now->endOfYear()]);
            }
        }

        // Pagination: 8 per page
        $events = $query->orderBy('start_time', 'asc')->paginate(8)->withQueryString();

        // Sidebar options:
        // cities: distinct non-null cities from events
        $cities = Event::query()
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->select('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $categories = Category::orderBy('name')->get();

        return view('landing', compact('events', 'cities', 'categories'));
    }
}

