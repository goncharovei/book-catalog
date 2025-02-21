<?php

namespace App\Common\Http\Middleware;

use Illuminate\Foundation\Configuration\Middleware;

final class AppHandler
{
    private array $aliases = [

    ];

    public function __construct(private readonly Middleware $middleware)
    {
        $this->middleware->alias($this->aliases);
    }

    public function handler(): void
    {
        $this->middleware->append(AppMiddleware::class);
    }

}
