<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'customer') {
            return redirect()->route('landing')->with('error', 'Akses ditolak. Anda bukan customer.');
        }

        return $next($request);
    }
}
