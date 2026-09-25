<?php

namespace App\Common\Exceptions;

use App\Api\V1\Exceptions\ApiHandler;
use App\Common\Service\SiteSide;
use App\Front\Exceptions\FrontHandler;
use Illuminate\Foundation\Configuration\Exceptions;

final readonly class ExceptionHandler
{
    public function __construct(private SiteSide $siteSide)
    {
    }

    public function __invoke(Exceptions $exceptions): void
    {
        resolve(AppHandler::class, compact('exceptions'))->handler();

        if ($this->siteSide->isFront())
        {
            resolve(FrontHandler::class, compact('exceptions'))->handler();
        }

        if ($this->siteSide->isApi())
        {
            resolve(ApiHandler::class, compact('exceptions'))->handler();
        }
    }
}
