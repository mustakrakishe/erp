<?php

use App\Http\Middleware\ExceptionIfAuthenticated;
use App\Http\Middleware\ForceJsonResponse;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware
            ->prependToGroup('api', ForceJsonResponse::class)
            ->alias(['guest' => ExceptionIfAuthenticated::class]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
