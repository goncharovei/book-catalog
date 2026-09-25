<?php

namespace App\Front\Publisher\Http\Controllers\Auth;

trait AuthRedirect
{
    public function redirectTo(): string
    {
        return route('publisher.cabinet.index');
    }
}
