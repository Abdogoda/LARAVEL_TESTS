<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProfileTest extends TestCase
{
    public function test_profile_page_has_update_profile_form(): void
    {
        $this->authenticate();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSeeInOrder(
            [
                '<form',
                'method="POST"',
                'action="' . route('profile.update') . '"',
                'name="name" id="name" value="' . auth()->user()->name . '"',
                'name="email" id="email" value="' . auth()->user()->email . '"',
                '</form>'
            ],
            false
        );
    }

    public function test_unauthenticated_user_cannot_update_profile()
    {
        $response = $this->patch('/profile', [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
        ]);
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_cannot_update_profile_when_email_or_name_is_missing()
    {
        $this->authenticate();

        $response = $this->patch('/profile', [
            'name' => '',
            'email' => '',
        ]);

        $response->assertSessionHasErrors(['name', 'email']);
    }

    public function test_authenticated_user_cannot_update_profile_when_email_is_invalid_or_already_exists()
    {
        $this->authenticate();
        $otherUser = $this->createUser();

        $this->patch('/profile', [
            'name' => 'Valid Name',
            'email' => 'invalid-email',
        ])->assertSessionHasErrors(['email']);

        $this->patch('/profile', [
            'name' => 'Valid Name',
            'email' => $otherUser->email,
        ])->assertSessionHasErrors(['email']);
    }

    public function test_authenticated_user_can_update_profile_with_valid_data()
    {
        $user = $this->authenticate();

        $response = $this->patch('/profile', [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);
    }

    public function test_authenticated_user_email_verification_status_is_reset_when_email_is_changed()
    {
        $user = $this->authenticate();
        $this->assertTrue($user->hasVerifiedEmail());

        $this->patch('/profile', [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'updatedemail@example.com',
        ]);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
        $this->assertNull($user->fresh()->email_verified_at);


        $this->get('/profile')->assertSee('title="Email verification status">Not Verified', false);
    }
}
