<?php

namespace App\Api\V1\Middleware;

use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

final class ApiHandler
{
    private array $aliases = [
        'abilities' => CheckAbilities::class,
        'ability' => CheckForAnyAbility::class,
    ];

    public function __construct(private readonly Middleware $middleware)
    {
        $this->middleware->alias($this->aliases);
    }

    public function handler(): void
    {
        $this->middleware->appendToGroup('api', ApiMiddleware::class);
    }

}
