<?php

namespace Tests\Feature\Public;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostsPageTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // Additional setup can be done here if needed
    }

    public function test_posts_page_is_accessible(): void
    {
        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('posts.index');
        $response->assertSee('All Posts');
    }

    public function test_posts_page_contains_navigation_links(): void
    {
        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            '<nav',
            'href="' . route('home') . '"',
            'href="' . route('posts.index') . '"',
            'href="' . route('categories.index') . '"',
            'href="' . route('login') . '"',
            'href="' . route('register') . '"',
            '</nav>'
        ], false);
    }

    public function test_posts_page_dose_not_require_authentication(): void
    {
        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee('All Posts');
    }

    public function test_authenticated_user_see_create_post_button(): void
    {
        $this->authenticate();

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee('href="' . route('posts.create') . '"', false);
        $response->assertSee('Create Post');
    }

    public function test_posts_page_does_not_have_posts(): void
    {
        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee('No posts found');
        $this->assertEmpty($response->viewData('posts'));
    }

    public function test_posts_page_displays_posts_when_available(): void
    {
        $posts = Post::factory()->count(3)->create(['status' => 'approved']);

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        foreach ($posts as $post) {
            $response->assertSee($post->title);
        }
        $this->assertNotEmpty($response->viewData('posts'));
    }

    public function test_unapproved_posts_are_not_displayed(): void
    {
        $approvedPosts = Post::factory()->count(2)->create(['status' => 'approved']);
        $unapprovedPosts = Post::factory()->count(2)->create(['status' => 'pending']);

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        foreach ($approvedPosts as $post) {
            $response->assertSee($post->title);
        }
        foreach ($unapprovedPosts as $post) {
            $response->assertDontSee($post->title);
        }
        $this->assertNotEmpty($response->viewData('posts'));
    }

    public function test_posts_page_pagination_works(): void
    {
        $posts = Post::factory()->count(15)->create(['status' => 'approved']);

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $this->assertEquals(6, $response->viewData('posts')->count());
        $response->assertSeeInOrder(['?page=2', '?page=3'], false);
        $response->assertSee('Next');
        $response->assertSee('Previous');
    }

    public function test_posts_page_pagination_second_page(): void
    {
        $posts = Post::factory()->count(15)->create(['status' => 'approved']);

        $response = $this->get(route('posts.index', ['page' => 2]));

        $response->assertStatus(200);
        $this->assertEquals(6, $response->viewData('posts')->count());
        $response->assertSeeInOrder(['?page=1', '?page=3'], false);
        $response->assertSee('Next');
        $response->assertSee('Previous');
    }

    public function test_search_functionality_on_posts_page(): void
    {
        $matchingPosts = Post::factory()->count(2)->create([
            'title' => 'UniqueTitleForSearchTest',
            'status' => 'approved'
        ]);
        $nonMatchingPosts = Post::factory()->count(3)->create(['status' => 'approved']);

        $response = $this->get(route('posts.index', ['search' => 'UniqueTitleForSearchTest']));

        $response->assertStatus(200);
        foreach ($matchingPosts as $post) {
            $response->assertSee($post->title);
        }
        foreach ($nonMatchingPosts as $post) {
            $response->assertDontSee($post->title);
        }
        $this->assertNotEmpty($response->viewData('posts'));
    }

    public function test_filter_by_category_on_posts_page(): void
    {
        $category = Category::factory()->create();
        $postsInCategory = Post::factory()->count(3)->create([
            'category_id' => $category->id,
            'status' => 'approved'
        ]);
        $postsNotInCategory = Post::factory()->count(3)->create(['status' => 'approved']);

        $response = $this->get(route('posts.index', ['category' => $category->slug]));

        $response->assertStatus(200);
        foreach ($postsInCategory as $post) {
            $response->assertSee($post->title);
        }
        foreach ($postsNotInCategory as $post) {
            $response->assertDontSee($post->title);
        }
        $this->assertNotEmpty($response->viewData('posts'));
    }

    public function test_sorting_options_on_posts_page(): void
    {
        $postA = Post::factory()->create([
            'title' => 'Alpha Post',
            'published_at' => now()->subDays(2),
            'status' => 'approved'
        ]);
        $postB = Post::factory()->create([
            'title' => 'Beta Post',
            'published_at' => now()->subDays(1),
            'status' => 'approved'
        ]);
        $postC = Post::factory()->create([
            'title' => 'Gamma Post',
            'published_at' => now(),
            'status' => 'approved'
        ]);

        // Default sorting (latest)
        $response = $this->get(route('posts.index'));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $postC->title,
            $postB->title,
            $postA->title
        ]);

        // Oldest first
        $response = $this->get(route('posts.index', ['sort' => 'oldest']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $postA->title,
            $postB->title,
            $postC->title
        ]);

        // Title alphabetical
        $response = $this->get(route('posts.index', ['sort' => 'title']));
        $response->assertStatus(200);
        $response->assertSeeInOrder([
            $postA->title,
            $postB->title,
            $postC->title
        ]);
    }

    // Test for individual post page
    public function test_individual_post_page_is_accessible(): void
    {
        $post = Post::factory()->create(['status' => 'approved']);

        $response = $this->get(route('posts.show', $post->slug));

        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
        $response->assertSee($post->title);
        $response->assertSee($post->content);
        $response->assertSee($post->user->name);
        $response->assertSee($post->category->name);
        $response->assertSee($post->published_at->format('M d, Y \a\t g:i A'));
    }
}
