<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // alias route middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            // alias lain (auth, verified, dsb) sudah disediakan bawaan
        ]);

        // contoh jika ingin menambahkan global middleware:
        // $middleware->append(\App\Http\Middleware\SomethingGlobal::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
