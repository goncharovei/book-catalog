<?php

namespace App\Common\Service\PublisherToken;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

final readonly class PublisherTokenCache
{
    public function __construct(private int $publisherId)
    {
    }

    public function create(PublisherTokenDto $tokenDto): bool
    {
        return Cache::forever(
            $this->key(),
            Crypt::encrypt($tokenDto)
        );
    }

    public function tokenInfo(): PublisherTokenDto
    {
        $data = Cache::get($this->key());
        if ($data === null)
        {
            return new PublisherTokenDto();
        }

        return Crypt::decrypt($data);
    }

    public function remove(): bool
    {
        return Cache::forget($this->key());
    }

    private function key(): string
    {
        return 'publisher-token-' . $this->publisherId;
    }
}
