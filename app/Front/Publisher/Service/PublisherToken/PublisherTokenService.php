<?php

namespace App\Front\Publisher\Service\PublisherToken;

use App\Common\Models\Publisher;
use App\Front\Publisher\Service\AbilityPublisher;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

final readonly class PublisherTokenService
{
    private Publisher $publisher;
    private PublisherTokenCache $cache;

    public function setDependencies(Publisher $publisher, PublisherTokenCache $cache): PublisherTokenService
    {
        $this->publisher = $publisher;
        $this->cache = $cache;

        return $this;
    }

    public function getPlainTextToken(): string|null
    {
        return $this->token()?->plainTextToken;
    }

    public function create(): NewAccessToken
    {
        $newAccessToken = null;

        DB::transaction(function () use (&$newAccessToken)
        {
            $newAccessToken = $this->publisher->createToken(
                $this->publisher->name,
                AbilityPublisher::values()
            );

            $this->cache->remove();
            $this->cache->create(new PublisherTokenDto(
                id: $newAccessToken->accessToken->id,
                accessToken: $newAccessToken->accessToken->token,
                plainTextToken: $newAccessToken->plainTextToken
            ));
        });

        return $newAccessToken;
    }

    public function token(): NewAccessToken|null
    {
        $tokenInfo = $this->cache->tokenInfo();
        if (empty($tokenInfo->id) || empty($tokenInfo->plainTextToken))
        {
            return null;
        }

        $personalAccessToken = PersonalAccessToken::find($tokenInfo->id);
        if (empty($personalAccessToken) || strcmp($personalAccessToken->token, $tokenInfo->accessToken) !== 0)
        {
            return null;
        }

        return new NewAccessToken($personalAccessToken, $tokenInfo->plainTextToken);
    }

    public function revoke(): void
    {
        DB::transaction(function ()
        {
            $this->publisher->tokens()->delete();
            $this->cache->remove();
        });
    }
}
