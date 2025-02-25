<?php

namespace App\Common\Service\PublisherToken;

final readonly class PublisherTokenDto
{
    public function __construct(
        public int $id = 0,
        public string $accessToken = '',
        public string $plainTextToken = ''
    )
    {
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
