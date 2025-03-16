<?php

namespace App\Common\Http\Middleware;

use Illuminate\Foundation\Configuration\Middleware as IlluminateMiddleware;

abstract class Middleware
{
    public function __construct(protected readonly IlluminateMiddleware $middleware)
    {
        $this->middleware->alias(array_merge(
            $this->middleware->getMiddlewareAliases(),
            static::$aliases
        ));
    }
}
