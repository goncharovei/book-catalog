<?php

namespace Front\Auth;

use App\Common\Models\Publisher;
use Illuminate\Support\Facades\Password;
use Tests\Feature\Front\TestCaseFront;

class PasswordTest extends TestCaseFront
{
    public function testRequest(): void
    {
        $this->get(route('publisher.auth.password.request'))->assertOk();
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
