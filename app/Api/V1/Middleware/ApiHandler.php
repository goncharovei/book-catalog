<?php

namespace App\Api\V1\Middleware;

use App\Common\Http\Middleware\Middleware;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

final class ApiHandler extends Middleware
{
    protected static array $aliases = [
        'abilities' => CheckAbilities::class,
        'ability' => CheckForAnyAbility::class,
    ];

    public function handler(): void
    {
        $this->middleware->appendToGroup('api', ApiMiddleware::class);
    }

}
