<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PostFunctionalityTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_created_post_appears_immediately_in_admin_dashboard(): void
    {
        // Create test data
        $adminUser = User::factory()->create(['role' => 'admin']);
        $regularUser = User::factory()->create(['role' => 'user']);
        $category = Category::factory()->create();

        $this->browse(function (Browser $userBrowser, Browser $adminBrowser) use ($regularUser, $adminUser, $category) {
            // Position browsers side by side
            $adminBrowser->resize(683, 768)->move(0, 0);
            $userBrowser->resize(683, 768)->move(683, 0);

            // Load the application in both browsers
            $adminBrowser->visit('/');
            $userBrowser->visit('/');

            // User browser: Login and go to profile
            $userBrowser->visit('/login')
                ->type('email', $regularUser->email)
                ->type('password', 'password')
                ->press('Sign In')
                ->refresh()
                ->assertPathIs('/profile');

            // Admin browser: Login and go to dashboard
            $adminBrowser->visit('/login')
                ->type('email', $adminUser->email)
                ->type('password', 'password')
                ->press('Sign In')
                ->visit('/admin')
                ->assertSee('Admin Dashboard')
                ->assertSee('No posts pending review at the moment.');

            sleep(2);

            // User browser: Click mobile menu button and then Write Post
            $userBrowser->click('button[onclick="toggleMobileMenu()"]') // Click mobile menu button
                ->pause(500)
                ->clickLink('Write Post') // Click Write Post from mobile menu
                ->type('title', 'Test Post for Admin Dashboard')
                ->select('category_id', $category->id)
                ->type('content', 'This is a test post that should appear immediately in admin dashboard.')
                ->press('Publish Post')
                ->pause(2000)
                ->assertRouteIs('posts.show', ['slug' => 'test-post-for-admin-dashboard']);

            // Admin browser: Refresh dashboard and verify post appears immediately
            $adminBrowser->pause(1000)
                ->refresh()
                ->pause(1000)
                ->assertSee('Posts Pending Review')
                ->assertSee('Test Post for Admin Dashboard')
                ->assertSeeIn('[title="Total posts pending review"]', '1');

            sleep(2);

            // Admin browser: Click on Review to review the post and approve it
            $adminBrowser->clickLink('Review')
                ->pause(1000)
                ->assertSee('Review Post')
                ->assertSee('Approve Post')
                ->typeSlowly('#approve_notes', 'Looks good to me.')
                ->press('#approve-post-button')
                ->pause(1000)
                ->assertPathIs('/admin')
                ->assertSee('No posts pending review at the moment.');

            sleep(2);

            // User browser: Refresh and verify post is now published
            $userBrowser->refresh()
                ->pause(1000)
                ->assertSee('Published');
        });
    }
}