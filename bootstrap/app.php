<?php

use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\BlockMaliciousBots;
use App\Http\Middleware\CaptureMarketingAttribution;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\TrackVisitorTraffic;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(BlockMaliciousBots::class);

        $middleware->web(append: [
            CaptureMarketingAttribution::class,
            SetLocale::class,
            SecurityHeaders::class,
            TrackVisitorTraffic::class,
        ]);

        $middleware->alias([
            'admin.auth' => AdminAuth::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            'checkout/paysky/*',
            'checkout/paypal/*',
            'traffic/event',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
