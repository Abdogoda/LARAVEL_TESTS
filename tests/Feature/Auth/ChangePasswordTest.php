<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    public function test_profile_page_has_change_password_form(): void
    {
        $this->authenticate();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSeeInOrder(
            [
                '<form',
                'method="POST"',
                'action="' . route('profile.password') . '"',
                'name="current_password" id="current_password"',
                'name="password" id="password"',
                'name="password_confirmation" id="password_confirmation"',
                '</form>'
            ],
            false
        );
    }

    public function test_user_cannot_change_password_when_sending_invalid_data(): void
    {
        $this->authenticate();

        // Current password is missing
        $this->patch(route('profile.password'), [
            'current_password' => '',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])->assertSessionHasErrors(['current_password']);

        // New password is missing
        $this->patch(route('profile.password'), [
            'current_password' => 'password',
            'password' => '',
            'password_confirmation' => '',
        ])->assertSessionHasErrors(['password']);

        // New password and confirmation do not match
        $this->patch(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'differentpassword',
        ])->assertSessionHasErrors(['password']);

        // Current password is incorrect
        $this->patch(route('profile.password'), [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ])->assertSessionHasErrors(['current_password']);
    }

    public function test_user_can_change_password_with_valid_data(): void
    {
        $user = $this->authenticate();

        $response = $this->patch(route('profile.password'), [
            'current_password' => 'password',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', 'Password updated successfully!');

        $user->refresh();

        // Verify that the password was changed
        $this->assertTrue(\Hash::check('newpassword', $user->password));

        // Log out the user before testing login with new password
        Auth::logout();

        // Verify that the user can log in with the new password
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'newpassword',
        ])->assertRedirect(route('profile.show'));

        // Log out again before testing old password
        Auth::logout();

        // Verify that the user cannot log in with the old password
        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors(['email']);
    }
}
