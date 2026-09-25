<?php

namespace Front\Auth;

use App\Common\Models\Publisher;
use Tests\Feature\Front\TestCaseFront;

class VerifyTest extends TestCaseFront
{
    public function testConfirm(): void
    {
        $publisher = Publisher::factory()->create();
        $response = $this->actingAs($publisher)
            ->get(route('publisher.auth.password.confirm'));

        $response->assertOk();
    }

    public function testEmailVerificationShow(): void
    {
        $publisher = Publisher::factory()->unverified()->create();
        $response = $this->actingAs($publisher)
            ->get(route('publisher.auth.verification.notice'));

        $response->assertOk();
    }


}
