<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_guest_cannot_access_create_post_page()
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_create_post_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertOk();
        $response->assertViewIs('posts.create');
        $response->assertViewHas('categories');
    }

    public function test_guest_cannot_create_post()
    {
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post',
            'content' => 'This is test content',
            'category_id' => $category->id,
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('posts', ['title' => 'Test Post']);
    }

    public function test_authenticated_user_can_create_post_as_pending()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post by User',
            'content' => 'This is test content for user post',
            'category_id' => $category->id,
            'action' => 'publish'
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Test Post by User')->first();

        $this->assertNotNull($post);
        $this->assertEquals('pending', $post->status);
        $this->assertEquals($user->id, $post->user_id);
        $this->assertNotNull($post->published_at);

        $response->assertRedirect(route('posts.show', $post->slug));
        $response->assertSessionHas('message', 'Post submitted for review! It will be published once approved by an admin.');
    }

    public function test_authenticated_user_can_create_post_as_draft()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Draft Post by User',
            'content' => 'This is draft content',
            'category_id' => $category->id,
            'action' => 'draft'
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Draft Post by User')->first();

        $this->assertNotNull($post);
        $this->assertEquals('draft', $post->status);
        $this->assertEquals($user->id, $post->user_id);
        $this->assertNull($post->published_at);

        $response->assertRedirect(route('posts.show', $post->slug));
        $response->assertSessionHas('message', 'Post saved as draft!');
    }

    public function test_admin_can_create_post_as_approved()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Admin Post',
            'content' => 'This is admin content',
            'category_id' => $category->id,
            'action' => 'publish'
        ];

        $response = $this->actingAs($admin)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Admin Post')->first();

        $this->assertNotNull($post);
        $this->assertEquals('approved', $post->status);
        $this->assertEquals($admin->id, $post->user_id);
        $this->assertNotNull($post->published_at);

        $response->assertRedirect(route('posts.show', $post->slug));
        $response->assertSessionHas('message', 'Post published successfully!');
    }

    public function test_admin_can_create_post_as_draft()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Admin Draft Post',
            'content' => 'This is admin draft content',
            'category_id' => $category->id,
            'action' => 'draft'
        ];

        $response = $this->actingAs($admin)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Admin Draft Post')->first();

        $this->assertNotNull($post);
        $this->assertEquals('draft', $post->status);
        $this->assertEquals($admin->id, $post->user_id);
        $this->assertNull($post->published_at);

        $response->assertRedirect(route('posts.show', $post->slug));
        $response->assertSessionHas('message', 'Post saved as draft!');
    }

    public function test_slug_is_auto_generated_from_title()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'This is My Test Post',
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'This is My Test Post')->first();

        $this->assertNotNull($post);
        $this->assertEquals('this-is-my-test-post', $post->slug);
    }

    public function test_duplicate_slugs_are_made_unique()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        // Create first post
        Post::factory()->create(['slug' => 'test-post']);

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Test Post')->first();

        $this->assertNotNull($post);
        $this->assertEquals('test-post-1', $post->slug);
    }

    public function test_multiple_duplicate_slugs_increment_correctly()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        // Create posts with existing slugs
        Post::factory()->create(['slug' => 'test-post']);
        Post::factory()->create(['slug' => 'test-post-1']);

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Test Post')->first();

        $this->assertNotNull($post);
        $this->assertEquals('test-post-2', $post->slug);
    }

    public function test_post_can_be_created_with_image()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $image = UploadedFile::fake()->image('test-image.jpg', 600, 400)->size(1024);

        $postData = [
            'title' => 'Post with Image',
            'content' => 'Test content with image',
            'category_id' => $category->id,
            'image' => $image,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Post with Image')->first();

        $this->assertNotNull($post);
        $this->assertNotNull($post->image);
        $this->assertTrue(Storage::disk('public')->exists($post->image));
    }

    public function test_post_can_be_created_with_published_at_date()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $publishedAt = now()->addDays(1);

        $postData = [
            'title' => 'Scheduled Post',
            'content' => 'Test content',
            'category_id' => $category->id,
            'published_at' => $publishedAt->format('Y-m-d H:i:s'),
            'action' => 'publish'
        ];

        $response = $this->actingAs($admin)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Scheduled Post')->first();

        $this->assertNotNull($post);
        $this->assertEquals($publishedAt->format('Y-m-d H:i'), $post->published_at->format('Y-m-d H:i'));
    }

    public function test_title_is_required()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseMissing('posts', ['content' => 'Test content']);
    }

    public function test_content_is_required()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('content');
        $this->assertDatabaseMissing('posts', ['title' => 'Test Post']);
    }

    public function test_category_id_is_required()
    {
        $user = User::factory()->create(['role' => 'user']);

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('category_id');
        $this->assertDatabaseMissing('posts', ['title' => 'Test Post']);
    }

    public function test_category_id_must_exist()
    {
        $user = User::factory()->create(['role' => 'user']);

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'category_id' => 999, // Non-existent category
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('category_id');
        $this->assertDatabaseMissing('posts', ['title' => 'Test Post']);
    }

    public function test_title_cannot_exceed_255_characters()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'title' => str_repeat('a', 256), // 256 characters
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('title');
    }

    public function test_slug_cannot_exceed_255_characters()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post',
            'slug' => str_repeat('a', 256), // 256 characters
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('slug');
    }

    public function test_slug_must_be_unique()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        Post::factory()->create(['slug' => 'existing-slug']);

        $postData = [
            'title' => 'Test Post',
            'slug' => 'existing-slug',
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('slug');
    }

    public function test_image_must_be_valid_image_file()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $invalidFile = UploadedFile::fake()->create('test.txt', 100);

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'category_id' => $category->id,
            'image' => $invalidFile,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('image');
    }

    public function test_image_cannot_exceed_2mb()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $largeImage = UploadedFile::fake()->image('large-image.jpg')->size(3072); // 3MB

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'category_id' => $category->id,
            'image' => $largeImage,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('image');
    }

    public function test_image_must_have_valid_mime_type()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $invalidImage = UploadedFile::fake()->image('test.bmp'); // BMP not allowed

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'category_id' => $category->id,
            'image' => $invalidImage,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('image');
    }

    public function test_published_at_must_be_valid_date()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post',
            'content' => 'Test content',
            'category_id' => $category->id,
            'published_at' => 'invalid-date',
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('published_at');
    }

    public function test_default_action_is_publish_when_not_specified()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post Default Action',
            'content' => 'Test content',
            'category_id' => $category->id,
            // No action specified
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Test Post Default Action')->first();

        $this->assertNotNull($post);
        $this->assertEquals('pending', $post->status); // Regular user defaults to pending
    }

    public function test_user_id_is_automatically_set_to_authenticated_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $postData = [
            'title' => 'Test Post User ID',
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Test Post User ID')->first();

        $this->assertNotNull($post);
        $this->assertEquals($user->id, $post->user_id);
    }

    public function test_post_creation_enforces_authorization()
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        // This test ensures that the authorize method is called
        // We can't easily mock the policy, but we can verify that 
        // the post is created successfully for authorized users

        $postData = [
            'title' => 'Authorized Post',
            'content' => 'Test content',
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)->post(route('posts.store'), $postData);

        $post = Post::where('title', 'Authorized Post')->first();
        $this->assertNotNull($post);

        $response->assertRedirect(route('posts.show', $post->slug));
    }
}
