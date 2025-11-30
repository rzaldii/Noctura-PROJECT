<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $organizerId = session('user_id');
        $organizer = DB::table('organizers')->where('id', $organizerId)->first();

        return view('organizer.profile', compact('organizer'));
    }
}
