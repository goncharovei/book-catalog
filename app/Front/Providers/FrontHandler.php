<?php

namespace App\Front\Providers;

use App\Front\Publisher\Providers\PublisherServiceProvider;

final class FrontHandler
{
    public static array $providers = [
        PublisherServiceProvider::class,
    ];

}
