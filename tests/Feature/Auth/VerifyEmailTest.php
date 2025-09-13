<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class VerifyEmailTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

    }

    public function test_that_profile_page_show_verify_email_button_for_unverified_user(): void
    {
        $this->authenticate($this->createUser(['email_verified_at' => null]));

        $response = $this->get(route('profile.show'));

        $response->assertStatus(200);
        $response->assertSee('Verify Email');
    }

    public function test_that_profile_page_does_not_show_verify_email_button_for_verified_user(): void
    {
        $this->authenticate($this->createUser());

        $response = $this->get(route('profile.show'));

        $response->assertStatus(200);
        $response->assertDontSee('Verify Email');
    }

    public function test_user_can_request_email_verification_link(): void
    {
        Notification::fake();

        $user = $this->createUser(['email_verified_at' => null]);
        $this->authenticate($user);

        $response = $this->post(route('verification.send'));

        $response->assertStatus(302);
        $response->assertSessionHas('message', 'Verification link sent!');

        Notification::assertSentTo(
            [$user],
            \Illuminate\Auth\Notifications\VerifyEmail::class
        );
    }

    public function test_user_can_verify_email_with_valid_signature(): void
    {
        $user = $this->createUser(['email_verified_at' => null]);
        $this->authenticate($user);

        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->get($verificationUrl);

        $response->assertStatus(302);
        $response->assertRedirect(route('profile.show'));
        $response->assertSessionHas('message', 'Email verified successfully!');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
