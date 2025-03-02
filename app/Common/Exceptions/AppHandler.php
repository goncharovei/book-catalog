<?php

namespace App\Common\Exceptions;

use Illuminate\Foundation\Configuration\Exceptions;

final readonly class AppHandler
{
    public function __construct(private Exceptions $exceptions)
    {

    }

    public function handler(): void
    {
        $this->exceptions->dontReportDuplicates();
    }

}
