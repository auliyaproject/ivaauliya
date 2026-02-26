<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class KasirOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'kasir') {
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}
