<?php

namespace Tests\Feature\User;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    public function test_unauthenticated_user_cannot_view_edit_post_page()
    {
        Post::factory()->create();
        $response = $this->get('/posts/1/edit');
        $response->assertRedirect('/login');
    }

    public function test_user_cannot_view_edit_post_page_of_another_user()
    {
        $this->authenticate();
        Post::factory()->create();

        $response = $this->get('/posts/1/edit');
        $response->assertStatus(403);
    }

    public function test_user_can_view_edit_post_page_of_own_post()
    {
        $this->authenticate();
        $post = Post::factory()->create(['user_id' => auth()->id()]);

        $response = $this->get(route('posts.edit', $post));
        $response->assertStatus(200);
        $response->assertSee('Edit Post');
        $response->assertSeeInOrder([
            'form',
            'method="POST"',
            'action="' . route('posts.update', $post) . '"',
            'name="title"',
            'name="category_id"',
            'name="content"',
            'Update Post',
            'Delete Post'
        ]);
    }

    public function test_user_can_update_own_post()
    {
        $this->authenticate();
        $post = Post::factory()->create(['user_id' => auth()->id()]);

        $response = $this->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'category_id' => 1,
            'content' => 'Updated content for the post.'
        ]);

        $post->refresh();
        $response->assertRedirect(route('posts.show', $post->slug));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'category_id' => 1,
            'content' => 'Updated content for the post.'
        ]);
    }

    public function test_user_cannot_update_own_post_with_invalid_data()
    {
        $user = $this->authenticate();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // First visit the edit page to set the referrer
        $this->get(route('posts.edit', $post));

        $response = $this->put(route('posts.update', $post), [
            'title' => '', // Invalid title
            'category_id' => 85222,
            'content' => 'Updated content for the post.'
        ]);

        $post->refresh();
        $response->assertRedirect(route('posts.edit', $post));
        $response->assertSessionHasErrors(['title', 'category_id']);
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $post->title, // Title should remain unchanged
            'category_id' => $post->category_id, // Category should remain unchanged
            'content' => $post->content
        ]);
    }

    public function test_post_after_update_must_be_reviewed_first()
    {
        $user = $this->authenticate();
        $post = Post::factory()->create(['user_id' => $user->id]);

        // First visit the edit page to set the referrer
        $this->get(route('posts.edit', $post));

        $response = $this->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'category_id' => 1,
            'content' => 'Updated content for the post.'
        ]);

        $post->refresh();
        $response->assertRedirect(route('posts.show', $post->slug));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Title',
            'category_id' => 1,
            'content' => 'Updated content for the post.',
            'status' => 'pending', // Post should now require review
            'reviewed_at' => null, // Post should be unpublished
            'reviewed_by' => null
        ]);

        $this->get(route('posts.index'))->assertDontSee($post->title);
    }
}
