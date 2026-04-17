<?php
use Illuminate\Support\Facades\Auth;

it('registres a user', function (): void {
    visit('/register')
        ->fill('name', 'Bulat')
        ->fill('email', 'bulat@gmail.com')
        ->fill('password', 'password')
        ->click('Create Account')
        ->assertPathIs('/ideas');

    $this->assertAuthenticated();

    expect(Auth::user())->toMatchArray([
        'name' => 'Bulat',
        'email' => 'bulat@gmail.com',
    ]);
});

it('registres a valid email', function (): void {
    visit('/register')
        ->fill('name', 'Bulat')
        ->fill('email', 'bulgmail.com')
        ->fill('password', 'password')
        ->click('Create Account')
        ->assertPathIs('/register');
});
