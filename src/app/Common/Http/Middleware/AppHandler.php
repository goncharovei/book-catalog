<?php

namespace App\Common\Http\Middleware;


final class AppHandler extends Middleware
{
    protected static array $aliases = [
        'json' => JsonMiddleware::class
    ];

    public function handler(): void
    {
        $this->middleware->append(AppMiddleware::class);
    }

}
