<?php

namespace App\Front\Providers;

use App\Common\Providers\ProviderFactory;
use App\Front\Publisher\Providers\PublisherServiceProvider;

final class FrontHandler extends ProviderFactory
{
    protected static array $providers = [
        PublisherServiceProvider::class,
    ];

}
