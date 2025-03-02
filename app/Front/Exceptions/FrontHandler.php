<?php

namespace App\Front\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;

final readonly class FrontHandler
{
    public function __construct(private Exceptions $exceptions)
    {

    }

    public function handler(): void
    {

    }

}
