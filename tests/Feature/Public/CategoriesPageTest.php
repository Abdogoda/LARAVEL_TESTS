<?php

namespace Tests\Feature\Public;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesPageTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // Additional setup can be done here if needed
    }

    public function test_categories_page_is_accessible(): void
    {
        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertViewIs('categories.index');
        $response->assertSee('Categories');
    }

    public function test_categories_page_contains_navigation_links(): void
    {
        $response = $this->get(route('categories.index'));

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

    public function test_categories_page_dose_not_require_authentication(): void
    {
        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Categories');
    }

    public function test_admin_user_see_create_category_button(): void
    {
        $this->authenticateAsAdmin();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('href="' . route('categories.create') . '"', false);
        $response->assertSee('Create Category');
    }

    public function test_admin_user_can_see_edit_category_button(): void
    {
        $this->authenticateAsAdmin();
        $category = Category::factory()->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $response->assertSee('href="' . route('categories.edit', $category) . '"', false);
    }

    public function test_categories_page_have_five_categories_by_seeder(): void
    {
        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        $this->assertCount(5, $response->viewData('categories'));
    }

    public function test_categories_page_displays_categories(): void
    {
        $categories = Category::factory()->count(3)->create();

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        foreach ($categories as $category) {
            $response->assertSee($category->name);
        }
        $this->assertCount(8, $response->viewData('categories'));
    }

    public function test_categories_page_displays_number_of_posts_in_each_category(): void
    {
        $category1 = Category::factory()->create(['name' => 'Category 1']);
        $category2 = Category::factory()->create(['name' => 'Category 2']);

        $category1->posts()->createMany(Post::factory()->count(2)->make(['status' => 'approved'])->toArray());
        $category2->posts()->createMany(Post::factory()->count(5)->make(['status' => 'approved'])->toArray());

        $response = $this->get(route('categories.index'));

        $response->assertStatus(200);
        foreach ([$category1, $category2] as $category) {
            $response->assertSee($category->posts_count . ' posts');
        }
    }

    // Test individual category page
    public function test_individual_category_page_is_accessible(): void
    {
        $category = Category::factory()->create();
        $category->posts()->createMany(Post::factory()->count(3)->make(['status' => 'approved'])->toArray());

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(200);
        $response->assertViewIs('categories.show');
        $response->assertSee($category->name);
        $response->assertSee($category->posts_count . ' posts in this category');
    }

    public function test_admin_user_can_see_edit_button_on_individual_category_page(): void
    {
        $this->authenticateAsAdmin();
        $category = Category::factory()->create();

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(200);
        $response->assertSee('href="' . route('categories.edit', $category) . '"', false);
    }

    public function test_individual_category_page_displays_posts_in_that_category(): void
    {
        $category = Category::factory()->create();
        $posts = $category->posts()->createMany(Post::factory()->count(3)->make(['status' => 'approved'])->toArray());

        $response = $this->get(route('categories.show', $category->slug));

        $response->assertStatus(200);
        foreach ($posts as $post) {
            $response->assertSee($post->title);
            $response->assertSee(route('posts.show', $post->slug));
        }
    }
}
