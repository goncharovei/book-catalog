<?php

namespace App\Front\Publisher\Events;

use App\Common\Models\Publisher;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PublisherTokenRefreshEvent
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function __construct(public Publisher $publisher, public bool $isShouldQueue = true)
    {

    }


}
