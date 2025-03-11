<?php

namespace Tests\Feature\Front;

use App\Front\Publisher\Events\PublisherTokenRefreshEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

class AuthTest extends TestCaseFront
{
    public function testLogin(): void
    {
        $this->get(route('publisher.auth.login'))->assertOk();
    }

    public function testRegisterForm(): void
    {
        $this->get(route('publisher.auth.register'))->assertOk();
    }

    public function testPublisherStore(): void
    {
        Event::fake();

        $password = fake()->password(minLength: 10);
        $requestData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password
        ];
        $response = $this->post(route('publisher.auth.register', $requestData));
        $response->assertValid();

        Event::assertDispatched(Registered::class);
        Event::assertDispatched(PublisherTokenRefreshEvent::class);
        $this->assertAuthenticated();

        $response->assertRedirect();
    }

}
