<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminVerified
{
    public function handle(Request $request, Closure $next)
    {
        // belum pilih role
        if (session('role') !== 'admin') {
            return redirect()->route('pilih.role');
        }

        if (!session('admin_verified')) {
            return redirect()->route('admin.verifikasi');
        }

        return $next($request);
    }
}
