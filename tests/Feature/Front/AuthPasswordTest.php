<?php

namespace Tests\Feature\Front;

use App\Common\Models\Publisher;
use Illuminate\Support\Facades\Password;

class AuthPasswordTest extends TestCaseFront
{
    public function testRequest(): void
    {
        $this->get(route('publisher.auth.password.request'))->assertOk();
    }

    public function testConfirm(): void
    {
        $response = $this->actingAs(Publisher::first())
            ->get(route('publisher.auth.password.confirm'));

        $response->assertOk();
    }

    public function testReset(): void
    {
        $publisher = Publisher::factory()->create();
        $requestData = [
            'token' => Password::broker()->createToken($publisher),
            'email' => $publisher->email
        ];

        $this->get(route('publisher.auth.password.reset', $requestData))->assertOk();
    }

}
