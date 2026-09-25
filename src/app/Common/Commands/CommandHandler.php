<?php

namespace App\Common\Commands;

use App\Api\V1\Commands\ApiHandler;
use App\Front\Commands\FrontHandler;

final readonly class CommandHandler
{
    public function __invoke(): array
    {
        return array_merge(
            AppHandler::getCommands(),
            FrontHandler::getCommands(),
            ApiHandler::getCommands()
        );
    }

}
