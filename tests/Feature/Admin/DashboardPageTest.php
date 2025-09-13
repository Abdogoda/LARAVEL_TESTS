<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardPageTest extends TestCase
{
    public function test_dashboard_page_cannot_be_rendered_for_guest_users(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/login');
    }

    public function test_dashboard_page_cannot_be_rendered_for_regular_users(): void
    {
        $this->authenticate();

        $response = $this->get('/admin');

        $response->assertStatus(403);
    }

    public function test_dashboard_page_can_be_rendered_for_admin_users(): void
    {
        $this->authenticateAsAdmin();

        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Admin Dashboard');
    }

    public function test_dashboard_page_displays_stats_and_show_pending_posts()
    {
        $this->authenticateAsAdmin();
        $pendingPosts = Post::factory()->count(5)->create(); // 5 pending posts
        Post::factory()->count(3)->create(['status' => 'approved']); // 3 approved posts
        Post::factory()->count(2)->create(['status' => 'rejected']); // 2 rejected posts

        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('title="Total posts pending review">5', false);
        $response->assertSee('title="Total posts approved">3', false);
        $response->assertSee('title="Total posts rejected">2', false);
        $response->assertSee('title="Total writers">10', false);

        foreach ($pendingPosts as $post) {
            $response->assertSee($post->title, false);
            $response->assertSee($post->user->name, false);
            $response->assertSee($post->category->name, false);
            $response->assertSee(route('admin.review-post', $post), false);
            $response->assertSee(route('posts.show', $post->slug), false);
        }
    }
}
