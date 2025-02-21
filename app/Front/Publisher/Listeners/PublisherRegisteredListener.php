<?php

namespace App\Front\Publisher\Listeners;

use App\Common\Models\Publisher;
use Illuminate\Auth\Events\Registered;

class PublisherRegisteredListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        if (!($event->user instanceof Publisher))
        {
            return;
        }

        $event->user->createToken($event->user->name, ['server:update']);//todo
    }
}
