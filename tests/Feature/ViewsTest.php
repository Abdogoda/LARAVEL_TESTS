<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewsTest extends TestCase
{
    public function test_the_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    public function test_the_test_page_is_accessible(): void
    {
        $response = $this->get('/test');

        $response->assertStatus(200);
        $response->assertViewIs('test');
        $response->assertSee('This is a test page.');
        $response->assertViewHasAll(['title', 'content']);
        $response->assertViewHas('title', 'Test Page');
        $response->assertSee('<h3>This is a subtitle for test page</h3>', false);
    }

    public function test_the_homepage_contains_welcome_text(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('BlogMaster Pro');
        $response->assertSee('Login');
        $response->assertSee('Sign Up');
        $response->assertDontSee('Random Text');
        $response->assertSeeText('Explore Posts');
        $response->assertSeeInOrder(['BlogMaster Pro', 'Powerful Features', 'Ready to Share Your Story?']);
    }

    public function test_login_page_has_form_inputs_for_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            '<form',
            'method="POST"',
            'action="',
            'name="email"',
            'name="password"',
            'type="submit"',
            '</form>'
        ]);
        $response->assertSee(route('register'), false);
    }
}
