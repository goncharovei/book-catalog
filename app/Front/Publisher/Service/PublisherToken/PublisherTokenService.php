<?php

namespace App\Front\Publisher\Service\PublisherToken;

use App\Common\Models\Publisher;
use App\Front\Publisher\Service\AbilityPublisher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

final class PublisherTokenService
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

    /**
     * @throws \Throwable
     */
    public function create(): NewAccessToken
    {
        try {
            DB::beginTransaction();

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

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error($e->getMessage(), [__CLASS__ . ' ' . __METHOD__]);
            throw $e;
        }

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

    /**
     * @throws \Throwable
     */
    public function revoke(): void
    {
        try {
            DB::beginTransaction();

            $this->publisher->tokens()->delete();
            $this->cache->remove();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error($e->getMessage(), [__CLASS__ . ' ' . __METHOD__]);
            throw $e;
        }
    }

    /**
     * @throws \Throwable
     */
    public function refresh(): void
    {
        try {
            DB::beginTransaction();

            $this->revoke();
            $this->create();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
