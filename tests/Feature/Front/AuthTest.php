<?php

namespace Tests\Feature\Front;

use App\Front\Publisher\Mail\PublisherRegisteredMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;

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
        Queue::fake();
        Notification::fake();
        Event::fake();
        Mail::fake();

        $password = fake()->password(minLength: 10);
        $requestData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password
        ];
        $response = $this->post(route('publisher.auth.register', $requestData));
        $response->assertValid();
        $this->assertAuthenticated();

        Event::assertDispatched(Registered::class);

        Mail::assertNotSent(PublisherRegisteredMail::class);
        Notification::assertNotSentTo(Auth::user(), VerifyEmail::class);
        Queue::assertNothingPushed();

        $response->assertRedirect();
    }

}
