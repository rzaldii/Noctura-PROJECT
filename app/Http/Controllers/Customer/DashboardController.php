<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('category', 'organizer')
            ->where('status', 'active');

        // --- Filter pencarian ---
        if ($request->filled('q')) {
            $query->where('name', 'ILIKE', '%' . $request->q . '%');
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('time')) {
            $now = Carbon::now();
            if ($request->time == 'today') {
                $query->whereDate('start_time', $now->toDateString());
            } elseif ($request->time == 'week') {
                $query->whereBetween('start_time', [$now->startOfWeek(), $now->endOfWeek()]);
            } elseif ($request->time == 'month') {
                $query->whereMonth('start_time', $now->month);
            } elseif ($request->time == 'year') {
                $query->whereYear('start_time', $now->year);
            }
        }

        // Pagination
        $events = $query->orderBy('start_time', 'asc')->paginate(8)->withQueryString();

        // Cities
        $cities = Event::query()
            ->whereNotNull('city')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        // Categories
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('customer.dashboard', compact('events', 'cities', 'categories'));
    }
}
