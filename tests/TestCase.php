<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function setUp(): void
    {
        parent::setUp();

        // Additional setup can be done here
    }

    public function createUser(array $attributes = [])
    {
        return User::factory()->create($attributes);
    }

    public function createAdmin(array $attributes = [])
    {
        return $this->createUser(array_merge($attributes, ['role' => 'admin']));
    }

    public function authenticate(User $user = null)
    {
        $user = $user ?? $this->createUser();

        $this->actingAs($user);

        return $user;
    }

    public function authenticateAsAdmin(User $admin = null)
    {
        $admin = $admin ?? $this->createAdmin();

        $this->actingAs($admin);

        return $admin;
    }
}
