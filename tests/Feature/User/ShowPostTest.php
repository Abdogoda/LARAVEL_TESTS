<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowPostTest extends TestCase
{
    public function test_user_can_view_his_pending_post()
    {
        $user = $this->authenticate();
        $post = $user->posts()->create([
            'title' => 'Pending Post',
            'slug' => 'pending-post',
            'content' => 'This is a pending post content.',
            'category_id' => 1,
            'status' => 'pending',
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(200);
        $response->assertSee($post->title, false);
        $response->assertSee($post->content, false);
        $response->assertSee('Pending', false);
    }

    public function test_user_cannot_view_others_pending_post()
    {
        $this->authenticate();
        $otherUser = $this->createUser();
        $post = $otherUser->posts()->create([
            'title' => 'Other User Pending Post',
            'slug' => 'other-user-pending-post',
            'content' => 'This is another user\'s pending post content.',
            'category_id' => 1,
            'status' => 'pending',
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(403);
    }

    public function test_user_can_see_edit_and_delete_buttons_on_his_own_post()
    {
        $user = $this->authenticate();
        $post = $user->posts()->create([
            'title' => 'User Post',
            'slug' => 'user-post',
            'content' => 'This is a user post content.',
            'category_id' => 1,
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(200);
        $response->assertSee('Edit', false);
        $response->assertSee('Delete', false);
    }

    public function test_user_cannot_see_edit_and_delete_buttons_on_others_post()
    {
        $this->authenticate();
        $otherUser = $this->createUser();
        $post = $otherUser->posts()->create([
            'title' => 'Other User Post',
            'slug' => 'other-user-post',
            'content' => 'This is another user\'s post content.',
            'category_id' => 1,
            'status' => 'approved',
            'published_at' => now(),
        ]);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(200);
        $response->assertDontSee('Edit', false);
        $response->assertDontSee('Delete', false);
    }
}
