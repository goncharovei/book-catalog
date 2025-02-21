<?php

namespace App\Front\Middleware;

use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class FrontHandler
{
    private array $aliases = [

    ];

    public function __construct(private readonly Middleware $middleware)
    {
        $this->middleware->alias($this->aliases);
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
            if (!$request->expectsJson() &&
                in_array('auth:web', $request->route()->middleware()) &&
                !Auth::guard('web')->check())
            {
                return route('publisher.auth.login');
            }

            return null;
        });

        $this->middleware->redirectUsersTo(function (Request $request)
        {
            if (in_array('guest:web', $request->route()->middleware()) &&
                Auth::guard('web')->check())
            {
                return route('book.list');
            }

            return null;
        });
    }
}
