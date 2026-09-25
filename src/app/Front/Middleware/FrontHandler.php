<?php

namespace App\Front\Middleware;

use App\Common\Http\Middleware\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Honeypot\ProtectAgainstSpam;

final class FrontHandler extends Middleware
{
    protected static array $aliases = [
        'ajax' => AjaxMiddleware::class,
        'anti-spam' => ProtectAgainstSpam::class
    ];

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
