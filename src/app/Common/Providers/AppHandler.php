<?php

namespace App\Common\Providers;

final class AppHandler extends ProviderFactory
{
    protected static array $providers = [
        AppServiceProvider::class,
    ];

}
