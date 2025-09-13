<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

    }

    public function test_user_can_access_login_page(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
        $response->assertSeeInOrder([
            '<form',
            'name="email"',
            'name="password"',
            'a href="' . route('password.request') . '"',
            'type="submit"',
            'a href="' . route('register') . '"',
            '</form>'
        ]);
    }

    public function test_user_cannot_login_with_no_credentials(): void
    {
        $response = $this->post(route('login'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_user_cannot_login_with_invalid_email(): void
    {
        $response = $this->post(route('login'), [
            'email' => 'invalid-email',
            'password' => 'password123'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = $this->createUser();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('profile.show'));
        $this->assertAuthenticated();
        $this->assertAuthenticatedAs($user);
        $this->assertEquals(auth()->user()->email, $user->email);
    }
}
