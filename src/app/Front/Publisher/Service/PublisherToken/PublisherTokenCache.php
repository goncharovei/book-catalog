<?php

namespace App\Front\Publisher\Service\PublisherToken;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Encryption\Encrypter;

final readonly class PublisherTokenCache
{
    public function __construct(
        private Repository $cache,
        private Encrypter $crypt,
        private int $publisherId)
    {
    }

    public function create(PublisherTokenDto $tokenDto): bool
    {
        return $this->cache->forever(
            $this->key(),
            $this->crypt->encrypt($tokenDto->toArray())
        );
    }

    public function tokenInfo(): PublisherTokenDto
    {
        $data = $this->cache->get($this->key());
        if ($data === null)
        {
            return new PublisherTokenDto();
        }

        return PublisherTokenDto::fromArray($this->crypt->decrypt($data));
    }

    public function remove(): bool
    {
        return $this->cache->forget($this->key());
    }

    private function key(): string
    {
        return 'publisher-token-' . $this->publisherId;
    }
}
