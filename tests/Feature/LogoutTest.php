<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_logout_when_not_authenticated(): void
    {
        $response = $this->post(route('logout'));

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_logout_when_authenticated(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
