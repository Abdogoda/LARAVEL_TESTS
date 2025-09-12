<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PostApprovedTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_post()
    {
        Notification::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $post = Post::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)
            ->patch(route('admin.approve-post', $post), [])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'approved',
        ]);

        Notification::assertSentTo(
            $post->user,
            \App\Notifications\PostApprovedNotification::class,
            function ($notification, $channels) use ($post) {
                return $notification->post->id === $post->id;
            }
        );
    }
}
