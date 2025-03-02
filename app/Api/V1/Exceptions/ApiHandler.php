<?php

namespace App\Api\V1\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;

final readonly class ApiHandler
{
    public function __construct(private Exceptions $exceptions)
    {

    }

    public function handler(): void
    {

    }

}
