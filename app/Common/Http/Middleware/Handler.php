<?php

namespace App\Common\Http\Middleware;

use App\Api\V1\Middleware\ApiHandler;
use App\Common\Service\SiteSide;
use App\Front\Middleware\FrontHandler;
use Illuminate\Foundation\Configuration\Middleware;

final readonly class Handler
{
    public function __construct(private SiteSide $siteSide)
    {

    }

    public function __invoke(Middleware $middleware): void
    {
        (new AppHandler($middleware))->handler();

        if ($this->siteSide->isFront())
        {
            (new FrontHandler($middleware))->handler();
        }

        if ($this->siteSide->isApi())
        {
            (new ApiHandler($middleware))->handler();
        }

    }

}
