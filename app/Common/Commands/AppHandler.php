<?php

namespace App\Common\Commands;

final class AppHandler extends CommandFactory
{
    protected static array $commands = [
        __DIR__,
        //InspireCommand::class
    ];

}
