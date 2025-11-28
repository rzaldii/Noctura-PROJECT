<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthCustom
{
    public function handle(Request $request, Closure $next)
    {
        // belum login
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login.');
        }

        // auto logout jika pindah browser/device
        if (session('browser_fingerprint') !== $request->header('User-Agent')) {
            session()->flush();
            return redirect()->route('login')->with('error', 'Session telah habis, silakan login ulang.');
        }

        return $next($request);
    }
}
