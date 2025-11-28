<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleOrganizer
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'organizer') {
            return redirect()->route('landing')->with('error', 'Akses ditolak. Anda bukan Event Organizer.');
        }

        return $next($request);
    }
}
