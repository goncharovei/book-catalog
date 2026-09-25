<?php

namespace App\Common\Http\Middleware;

use App\Api\V1\Middleware\ApiHandler;
use App\Common\Service\SiteSide;
use App\Front\Middleware\FrontHandler;
use Illuminate\Foundation\Configuration\Middleware;

final readonly class MiddlewareHandler
{
    public function __construct(private SiteSide $siteSide)
    {

    }

    public function __invoke(Middleware $middleware): void
    {
        resolve(AppHandler::class, compact('middleware'))->handler();

        if ($this->siteSide->isFront())
        {
            resolve(FrontHandler::class, compact('middleware'))->handler();
        }

        if ($this->siteSide->isApi())
        {
            resolve(ApiHandler::class, compact('middleware'))->handler();
        }

    }

}
