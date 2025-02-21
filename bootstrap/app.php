<?php

use App\Common\Http\Middleware\Handler as MiddlewareHandler;
use App\Common\Service\SiteSide;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(new MiddlewareHandler(SiteSide::getInstance()))
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
