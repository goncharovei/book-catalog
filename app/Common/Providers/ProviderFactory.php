<?php

namespace App\Common\Providers;

abstract class ProviderFactory
{
    public static function getProviders(): array
    {
        return static::$providers;
    }
}
