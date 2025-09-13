<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_that_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertOk();
    }

    public function test_that_posts_page_is_accessible(): void
    {
        $response = $this->get('/posts');

        $response->assertOk();
    }

    public function test_that_non_existing_page_returns_404(): void
    {
        $response = $this->get('/non-existing-page');

        $response->assertStatus(404);
        $response->assertNotFound();
    }

    public function test_that_authenticated_user_cannot_access_profile_and_redirect_to_login_page(): void
    {
        $response = $this->get('/profile');

        $response->assertRedirect('/login');
    }


    // Test methods
    public function test_that_get_users_route_return_users()
    {
        $response = $this->get('/users');
        $response->assertStatus(200);
        $response->assertJsonIsArray();
        $response->assertJsonCount(2);
        $response->assertJsonFragment(['name' => 'Sia']);
        $response->assertJsonFragment(['name' => 'John']);
    }

    public function test_that_get_user_by_id_route_return_user()
    {
        $response = $this->get('/users/1');
        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Sia']);
    }

    public function test_that_non_existing_user_id_return_404()
    {
        $response = $this->get('/users/999');
        $response->assertNotFound();
    }

    public function test_that_post_users_route_create_new_user()
    {
        $response = $this->post('/users', [
            'name' => 'Alice',
            'age' => 28
        ]);
        $response->assertCreated();
        $response->assertJsonFragment(['name' => 'Alice']);
        $response->assertJsonFragment(['age' => 28]);
    }

    public function test_that_put_user_route_update_existing_user()
    {
        $response = $this->put('/users/1', [
            'name' => 'Sia Updated',
            'age' => 26
        ]);
        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Sia Updated']);
        $response->assertJsonFragment(['age' => 26]);
    }

    public function test_that_delete_user_route_deletes_existing_user()
    {
        $response = $this->delete('/users/1');
        $response->assertOk();
        $response->assertSee('User deleted successfully');
    }
}
