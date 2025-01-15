<?php

use App\Exceptions\Handler;
use App\Http\Middleware\EnforceJsonResponse;
use App\Http\Middleware\HasSetPinMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'enforceJsonResponse' => EnforceJsonResponse::class,
            'has.set.pin' => HasSetPinMiddleware::class
        ]);

        $middleware->api([
            EnforceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Handle exceptions for JSON responses
        // 
        // If the request expects a JSON response, then we want to render the exception
        // in a format that is easy to parse by the client.
        // This is done by using the `Handler` class from the `app/Exceptions` folder.
        // The handler will convert the exception into a JSON response.
        $exceptions->renderable(function (\Throwable $e, $request) {
            if ($request->expectsJson()) {
                $handler = new Handler(app());
                return $handler->render($request, $e);
            }
        });
    })->create();
