<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    public function test_create_post_page_cannot_be_rendered_for_guest_users(): void
    {
        $response = $this->get('/posts/create');

        $response->assertRedirect('/login');
    }

    public function test_create_post_page_can_be_rendered_for_authenticated_users(): void
    {
        $this->authenticate();

        $response = $this->get('/posts/create');

        $response->assertStatus(200);
        $response->assertSee('Create New Post');
        $response->assertSeeInOrder([
            '<form',
            'method="POST"',
            'action="' . route('posts.store') . '"',
            'name="title" id="title"',
            'name="category_id" id="category_id"',
            'name="content" id="content"',
            '</form>'
        ], false);
    }

    public function test_user_got_errors_when_sending_invalid_data_to_create_post(): void
    {
        $this->authenticate();

        $this->post(route('posts.store'), [
            'title' => '',
            'category_id' => 1,
            'content' => 'This is a sample post content.',
        ])->assertSessionHasErrors(['title']);

        // Category is missing
        $this->post(route('posts.store'), [
            'title' => 'Sample Post',
            'category_id' => '',
            'content' => 'This is a sample post content.',
        ])->assertSessionHasErrors(['category_id']);

        // Content is missing
        $this->post(route('posts.store'), [
            'title' => 'Sample Post',
            'category_id' => 1,
            'content' => '',
        ])->assertSessionHasErrors(['content']);
    }

    public function test_user_can_create_post_when_sending_valid_data(): void
    {
        $this->authenticate();

        $response = $this->post(route('posts.store'), [
            'title' => 'Sample Post',
            'category_id' => 1,
            'content' => 'This is a sample post content.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Sample Post',
            'category_id' => 1,
            'content' => 'This is a sample post content.',
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);
    }

    public function test_user_can_create_draft_post(): void
    {
        $this->authenticate();

        $response = $this->post(route('posts.store'), [
            'title' => 'Draft Post',
            'category_id' => 1,
            'content' => 'This is a draft post content.',
            'action' => 'draft'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Draft Post',
            'category_id' => 1,
            'content' => 'This is a draft post content.',
            'user_id' => auth()->id(),
            'status' => 'draft'
        ]);
    }
}
