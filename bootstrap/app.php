<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminVerified;
use App\Http\Middleware\KasirVerified;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminVerified::class,
            'kasir' => KasirVerified::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        // BIARKAN KOSONG – ini WAJIB ADA
    })

    ->create();
