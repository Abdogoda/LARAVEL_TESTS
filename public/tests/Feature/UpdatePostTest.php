<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_update_others_post()
    {
        $post = Post::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'category_id' => $post->category_id,
        ]);

        $response->assertStatus(403);

        $post->refresh();
        $this->assertNotEquals('Updated Title', $post->title);
    }

    public function test_user_can_update_own_post()
    {
        $post = Post::factory()->create();

        $response = $this->actingAs($post->user)->put(route('posts.update', $post), [
            'title' => 'Updated Title',
            'content' => 'Updated content',
            'category_id' => $post->category_id,
        ]);

        $post->refresh();
        $response->assertRedirect(route('posts.show', $post->slug));

        $this->assertEquals('Updated Title', $post->title);
        $this->assertEquals('Updated content', $post->content);
    }
}
