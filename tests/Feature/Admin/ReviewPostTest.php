<?php

namespace Tests\Feature\Admin;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ReviewPostTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Notification::fake();
    }

    public function test_unauthenticated_and_regular_users_cannot_view_review_post_page()
    {
        $post = Post::factory()->create();
        $this->get(route('admin.review-post', $post))->assertRedirect('/login');

        $this->authenticate();
        $this->get(route('admin.review-post', $post))->assertStatus(403);
    }

    public function test_admin_can_view_review_post_page()
    {
        $this->authenticateAsAdmin();
        $post = Post::factory()->create();

        $response = $this->get(route('admin.review-post', $post));

        $response->assertStatus(200);
        $response->assertSee('Review Post');
        $response->assertSee($post->title, false);
        $response->assertSeeInOrder([
            'Approve Post',
            'Reject Post'
        ]);
    }

    public function test_admin_cannot_review_non_pending_post()
    {
        $this->authenticateAsAdmin();
        $post = Post::factory()->create(['status' => 'approved']);

        $response = $this->get(route('admin.review-post', $post));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error', 'Only pending posts can be reviewed.');
    }

    // Test Approve Post and Reject Post functionalities can be added here
    public function test_admin_can_approve_post()
    {
        $this->authenticateAsAdmin();
        $post = Post::factory()->create();

        $this->get(route('admin.review-post', $post))->assertStatus(200);

        $response = $this->patch(route('admin.approve-post', $post));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('message', 'Post approved successfully!');

        $post->refresh();
        $this->assertEquals('approved', $post->status);
        $this->assertEquals(auth()->id(), $post->reviewed_by);

        Notification::assertSentTo(
            [$post->user],
            \App\Notifications\PostApprovedNotification::class,
            function ($notification, $channels) use ($post) {
                return $notification->post->id === $post->id;
            }
        );
    }

    public function test_admin_can_reject_post()
    {
        $this->authenticateAsAdmin();
        $post = Post::factory()->create();

        $this->get(route('admin.review-post', $post))->assertStatus(200);

        $response = $this->patch(route('admin.reject-post', $post), [
            'notes' => 'The post does not meet our quality standards.'
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('message', 'Post rejected with feedback.');

        $post->refresh();
        $this->assertEquals('rejected', $post->status);
        $this->assertEquals(auth()->id(), $post->reviewed_by);
        $this->assertEquals('The post does not meet our quality standards.', $post->review_notes);

        Notification::assertSentTo(
            [$post->user],
            \App\Notifications\PostRejectedNotification::class,
            function ($notification, $channels) use ($post) {
                return $notification->post->id === $post->id;
            }
        );
    }

    public function test_reject_post_requires_notes()
    {
        $this->authenticateAsAdmin();
        $post = Post::factory()->create();

        $this->get(route('admin.review-post', $post))->assertStatus(200);

        $response = $this->patch(route('admin.reject-post', $post), [
            'notes' => '' // Empty notes
        ]);

        $response->assertSessionHasErrors('notes');

        $post->refresh();
        $this->assertEquals('pending', $post->status); // Status should remain pending
        $this->assertNull($post->reviewed_by);
        $this->assertNull($post->review_notes);
    }

    public function test_scheduled_post_after_approved_dose_not_go_live_immediately()
    {
        $this->authenticateAsAdmin();
        $post = Post::factory()->create([
            'published_at' => now()->addDay() // Scheduled for future
        ]);

        $this->get(route('admin.review-post', $post))->assertStatus(200);

        $response = $this->patch(route('admin.approve-post', $post));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('message', 'Post approved successfully!');

        $post->refresh();
        $this->assertEquals('approved', $post->status);
        $this->assertEquals(auth()->id(), $post->reviewed_by);
        // published_at should remain unchanged
        $this->assertTrue($post->published_at->isFuture());

        $this->get(route('posts.index'))->assertDontSee($post->title);
    }
}
