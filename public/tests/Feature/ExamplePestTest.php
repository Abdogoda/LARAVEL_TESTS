<?php

use App\Models\User;


beforeEach(function () {
    $this->user = User::factory()->create();
});

test('the home page is accessible', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});


test('user can access the login page', function () {
    get(route('login'))
        ->assertStatus(200)
        ->assertViewIs('auth.login')
        ->assertSeeInOrder([
            '<form',
            'name="email"',
            'name="password"',
            'type="submit"',
            '</form>'
        ]);
});

test('user can login with valid credentials', function () {
    post(route('login', [
        'email' => $this->user->email,
        'password' => 'password'
    ]))->assertStatus(302)
        ->assertRedirect(route('profile.show'));

    // $this->assertEquals($user->email, auth()->user()->email);
    expect(auth()->user()->email)->toBe($this->user->email);
});