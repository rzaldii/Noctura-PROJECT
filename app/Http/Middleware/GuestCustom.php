<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestCustom
{
    public function handle(Request $request, Closure $next)
    {
        if (session('logged_in')) {
            // Jika sudah login, arahkan ke dashboard role masing-masing
            return redirect()->route(session('role') . '.dashboard');
        }

        return $next($request);
    }
}
