<?php

namespace App\Front\Publisher\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublisherTokenRefreshEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     */
    public function __construct()
    {

    }


}
