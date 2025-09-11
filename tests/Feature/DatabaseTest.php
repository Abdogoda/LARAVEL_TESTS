<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use refreshDatabase;

    public function test_that_user_table_does_not_exist_if_not_using_refresh_database()
    {
        // $this->assertFalse(\Schema::hasTable('users'));
        $this->assertTrue(\Schema::hasTable('users'));
    }

    public function test_that_users_table_has_no_records()
    {
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseEmpty('users');
    }

    public function test_that_users_table_has_records_after_creating_a_user()
    {
        User::factory()->count(6)->create();

        $this->assertDatabaseCount('users', 6);
    }

    public function test_that_users_table_is_empty_in_a_new_test_method()
    {
        $this->assertDatabaseCount('users', 0);
    }

    public function test_that_users_table_has_records_after_running_database_seeder()
    {
        $this->seed(AdminUserSeeder::class);

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('categories', 0);
    }

    public function test_that_users_table_has_user_info_after_creating_a_user()
    {
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
        $this->assertDatabaseMissing('users', [
            'name' => 'Jane Doe',
        ]);
    }

    public function test_that_user_can_be_soft_deleted()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'deleted_at' => null,
        ]);

        $user->delete();

        $this->assertSoftDeleted($user);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }

    public function test_that_user_can_be_restored_after_soft_delete()
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertSoftDeleted($user);

        $user->restore();

        $this->assertNotSoftDeleted($user);
        $this->assertDatabaseHas('users', [
            'id' => $user->id
        ]);
    }

    public function test_that_user_can_be_force_deleted()
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertSoftDeleted($user);

        $user->forceDelete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);
    }

    public function test_that_user_has_many_posts_relationship()
    {
        $user = User::factory()->hasPosts(2)->create();

        $this->assertCount(2, $user->posts);
        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
        ]);
    }
}
