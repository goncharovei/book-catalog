<?php

namespace Tests\Feature\Front;

use App\Common\Models\Publisher;
use App\Front\Publisher\Listeners\PublisherRegisteredListener;
use App\Front\Publisher\Mail\PublisherRegisteredMail;
use App\Front\Publisher\Notifications\PublisherVerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
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
        Event::assertListening(
            Registered::class,
            PublisherRegisteredListener::class
        );
        Mail::assertNotSent(PublisherRegisteredMail::class);
        Notification::assertNotSentTo(Auth::user(), PublisherVerifyEmailNotification::class);
        Queue::assertNothingPushed();

        $response->assertRedirect();
    }

    public function testPublisherRegisteredMail(): void
    {
        Mail::fake();

        $publisher = new Publisher([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ]);

        $letter = new PublisherRegisteredMail($publisher);
        $letter->assertSeeInHtml($publisher['name']);
        $letter->assertSeeInHtml($publisher['email']);

        Mail::to(config('app.admin_email'))->send($letter);
        Mail::assertQueued(PublisherRegisteredMail::class, function ($mail) {
            return $mail->hasTo(config('app.admin_email'));
        });
    }

    public function testPublisherVerifyEmailNotification(): void
    {
        Notification::fake();

        $publisher = Publisher::factory()->create();
        $notification = new PublisherVerifyEmailNotification();
        $rendered = $notification->toMail($publisher)->render();

        $this->assertStringContainsString(Lang::get('Verify Email Address'), $rendered);
    }
}

