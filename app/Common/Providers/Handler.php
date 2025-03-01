<?php

namespace App\Common\Providers;

use App\Api\V1\Providers\ApiHandler;
use App\Common\Service\SiteSide;
use App\Front\Providers\FrontHandler;

final readonly class Handler
{
    public function __construct(private SiteSide $siteSide)
    {

    }

    public function __invoke(): array
    {
        $providers = match (true) {
            $this->siteSide->isFront() => FrontHandler::$providers,
            $this->siteSide->isApi() => ApiHandler::$providers
        };

        return array_merge(AppHandler::$providers, $providers);
    }

}
