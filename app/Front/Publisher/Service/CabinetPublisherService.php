<?php

namespace App\Front\Publisher\Service;

use App\Common\Models\Publisher;

final class CabinetPublisherService
{
    private Publisher $publisher;

    public function setPublisher(Publisher $publisher): CabinetPublisherService
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function currentAccessToken(): string|null
    {
        return $this->publisher->currentAccessToken()?->token;
    }
}
