<?php

use App\Common\Commands\CommandHandler;
use App\Common\Helper\Site;
use App\Common\Http\Middleware\MiddlewareHandler;
use App\Common\Exceptions\ExceptionHandler;
use App\Common\Service\SiteSide;
use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: Site::APP_HEALTH_UP_URL,
    )
    ->withCommands(call_user_func(resolve(
        CommandHandler::class
    )))
    ->withMiddleware(resolve(
        MiddlewareHandler::class,
        ['siteSide' => SiteSide::getInstance()]
    ))
    ->withExceptions(resolve(
        ExceptionHandler::class,
        ['siteSide' => SiteSide::getInstance()]
    ))
    ->create();
