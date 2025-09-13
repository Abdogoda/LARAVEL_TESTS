<?php

namespace Tests\Feature\User;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeletePostTest extends TestCase
{
    public function test_unauthenticated_user_cannot_delete_post()
    {
        $post = Post::factory()->create();
        $response = $this->delete(route('posts.destroy', $post));
        $response->assertRedirect('/login');
    }

    public function test_user_cannot_delete_post_of_another_user()
    {
        $this->authenticate();
        $post = Post::factory()->create();
        $response = $this->delete(route('posts.destroy', $post));
        $response->assertStatus(403);
    }

    public function test_user_can_delete_own_post()
    {
        $this->authenticate();
        $post = Post::factory()->create(['user_id' => auth()->id()]);

        // First visit the edit page to set the referrer
        $this->get(route('posts.edit', $post));

        $response = $this->delete(route('posts.destroy', $post));
        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
