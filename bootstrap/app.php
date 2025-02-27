<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Artisan;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
    
Route::get('/migrate', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return '✅ Migrations ran successfully!';
    } catch (\Exception $e) {
        return '❌ Error: ' . $e->getMessage();
    }
});

Route::get('/setup', function () {
    try {
        // Generate app key
        Artisan::call('key:generate', ['--force' => true]);

        // Run migrations
        Artisan::call('migrate', ['--force' => true]);

        return response()->json([
            'message' => '✅ Key generated and migrations run successfully!',
            'output' => Artisan::output(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => '❌ Error running setup: ' . $e->getMessage(),
        ]);
    }
});
