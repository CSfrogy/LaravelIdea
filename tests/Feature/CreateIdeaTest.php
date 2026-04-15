<?php

use App\Models\User;

it('creates an idea', function (): void {
    $this->actingAs($user = User::factory()->create());
    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'some example')
        ->click("@button-status-completed")
        ->fill('description', 'some example description')
        ->fill('@new-link', 'https://youtube.com')
        ->click('@submit-new-link-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($user->ideas()->first())->toMatchArray([
        'title' => 'some example',
        'status' => 'completed',
        'description' => 'some example description',
        'links' => ['https://youtube.com'],
    ]);
});
