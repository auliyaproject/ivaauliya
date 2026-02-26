<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KasirVerified
{
    public function handle(Request $request, Closure $next)
    {
        // belum pilih role
        if (!session()->has('role')) {
            return redirect()->route('pilih.role');
        }

        

        return $next($request);
    }
}
