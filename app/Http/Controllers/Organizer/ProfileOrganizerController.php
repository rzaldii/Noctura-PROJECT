<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organizer;

class ProfileOrganizerController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $organizer = Organizer::findOrFail($userId);

        return view('organizer.profile', compact('organizer'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('landing')->with('success', 'Berhasil logout.');
    }
}
