<?php

namespace Tests\Feature\Auth;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfilePageTest extends TestCase
{
    public function test_profile_page_cannot_be_rendered_for_guest_users(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }

    public function test_profile_page_can_be_rendered_for_authenticated_users(): void
    {
        $this->authenticate();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Profile');
    }

    public function test_profile_page_displays_account_status_for_regular_user(): void
    {
        $this->authenticate();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('title="account status">User', false);
    }

    public function test_profile_page_displays_account_status_for_admin_user(): void
    {
        $this->authenticateAsAdmin();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('title="account status">Admin', false);
    }

    public function test_profile_page_displays_user_posts_count(): void
    {
        $user = $this->authenticate();
        $user->posts()->createMany(Post::factory()->count(3)->make()->toArray());

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('title="my posts">3', false);

        foreach ($user->posts as $post) {
            $response->assertSee($post->title, false);
        }
    }

    public function test_profile_page_displays_email_verification_status(): void
    {
        $this->authenticate();

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('title="Email verification status">Verified', false);
    }

    public function test_profile_page_displays_email_not_verified_status(): void
    {
        $this->authenticate($this->createUser(['email_verified_at' => null]));

        $response = $this->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('title="Email verification status">Not Verified', false);
    }

}
