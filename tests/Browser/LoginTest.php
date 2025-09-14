<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    public function testLoginPage(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                ->clickLink('Login')
                ->assertSee('Welcome Back')
                ->typeSlowly('email', $user->email)
                ->type('password', 'password')
                ->press('Sign In')
                ->pause(1000)
                ->assertSee('Profile')
                ->assertSee($user->name);

            sleep(3);
        });
    }
}
