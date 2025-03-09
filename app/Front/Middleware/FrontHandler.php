<?php

namespace App\Front\Middleware;

use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class FrontHandler
{
    private array $aliases = [
        'ajax' => AjaxMiddleware::class
    ];

    public function __construct(private readonly Middleware $middleware)
    {
        $this->middleware->alias(array_merge(
            $this->middleware->getMiddlewareAliases(),
            $this->aliases
        ));
    }

    public function handler(): void
    {
        $this->middleware->appendToGroup('web', FrontMiddleware::class);

        $this->authRedirects();
    }

    private function authRedirects(): void
    {
        $this->middleware->redirectGuestsTo(function (Request $request)
        {
            if (!Auth::guard('web')->check())
            {
                return route('publisher.auth.login');
            }

            return null;
        });

    }
}
