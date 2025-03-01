<?php

use App\Common\Providers\Handler;
use App\Common\Service\SiteSide;

return call_user_func(resolve(
    Handler::class,
    ['siteSide' => SiteSide::getInstance()]
));
