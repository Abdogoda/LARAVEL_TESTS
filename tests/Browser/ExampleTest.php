<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    public function testBasicExample(): void
    {
        $user = User::factory()->create();
        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->assertSee('Sign in to your account')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Sign In')
                ->refresh()
                ->assertSee('Profile')
                ->assertPathIs('/profile')
                ->assertSee($user->name);
        });
    }
}
