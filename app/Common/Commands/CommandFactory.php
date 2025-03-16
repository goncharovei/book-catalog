<?php

namespace App\Common\Commands;

abstract class CommandFactory
{
    public static function getCommands(): array
    {
        return static::$commands;
    }
}
