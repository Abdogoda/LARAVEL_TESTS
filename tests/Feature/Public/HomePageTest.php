<?php

namespace Tests\Feature\Public;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // Additional setup can be done here if needed
    }

    public function test_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertSee('BlogMaster Pro');
    }

    public function test_home_page_contains_navigation_links(): void
    {
        $response = $this->get('/');

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

    public function test_home_page_dose_not_require_authentication(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Welcome to BlogMaster Pro');
    }

    public function test_unauthenticated_user_sees_login_and_register_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('href="' . route('login') . '"', false);
        $response->assertSee('href="' . route('register') . '"', false);
    }

    public function test_authenticated_user_see_write_post_button_and_profile_link_and_logout_button(): void
    {
        $this->authenticate();
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('href="' . route('posts.create') . '"', false);
        $response->assertSee('href="' . route('profile.show') . '"', false);
        $response->assertSee('form method="POST" action="' . route('logout') . '"', false);
    }

    public function test_authenticated_admin_user_sees_admin_dashboard_link(): void
    {
        $this->authenticateAsAdmin();
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('href="' . route('admin.dashboard') . '"', false);
    }

    public function authenticated_user_see_his_name_in_navigation_bar(): void
    {
        $user = $this->authenticate();
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee(e($user->name));
    }
}
