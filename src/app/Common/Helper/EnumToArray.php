<?php

namespace App\Common\Helper;

trait EnumToArray
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function array(): array
    {
        return array_combine(self::values(), array_map(fn ($case) => $case->label(), self::cases()));
    }
}
