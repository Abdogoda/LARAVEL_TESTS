<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

    }

    public function test_forgot_password_form_display(): void
    {
        $response = $this->get(route('password.request'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
        $response->assertSeeInOrder([
            '<form',
            'name="email"',
            '<button',
            'a href="' . route('login') . '"',
            '</form>'
        ]);
    }

    public function test_user_cannot_request_password_reset_with_invalid_email()
    {
        $response = $this->post(route('password.email'), [
            'email' => 'invalid-email'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_can_request_password_reset_with_valid_email()
    {
        Notification::fake();

        $user = $this->createUser();

        $response = $this->post(route('password.email'), [
            'email' => $user->email
        ]);

        $response->assertStatus(302);

        Notification::assertSentTo(
            [$user],
            \Illuminate\Auth\Notifications\ResetPassword::class
        );
    }

    public function test_user_can_reset_password_with_valid_token()
    {
        Notification::fake();

        $user = $this->createUser();

        $this->post(route('password.email'), [
            'email' => $user->email
        ]);

        Notification::assertSentTo(
            [$user],
            \Illuminate\Auth\Notifications\ResetPassword::class,
            function ($notification) use ($user) {
                $response = $this->post(route('password.update'), [
                    'token' => $notification->token,
                    'email' => $user->email,
                    'password' => 'newpassword123',
                    'password_confirmation' => 'newpassword123',
                ]);

                $response->assertStatus(302);
                $response->assertRedirect(route('login'));

                $this->assertCredentials([
                    'email' => $user->email,
                    'password' => 'newpassword123',
                ]);
                $user->refresh();

                return true;
            }
        );

        // test user cannot use the old password to login
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password', // old password
        ])->assertStatus(302)->assertSessionHasErrors('email');
    }

}
