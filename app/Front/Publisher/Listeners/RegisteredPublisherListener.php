<?php

namespace App\Front\Publisher\Listeners;

use App\Common\Models\Publisher;
use App\Front\Publisher\Service\AbilityPublisher;
use Illuminate\Auth\Events\Registered;

class RegisteredPublisherListener
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

        $event->user->createToken($event->user->name, AbilityPublisher::values());
    }
}
