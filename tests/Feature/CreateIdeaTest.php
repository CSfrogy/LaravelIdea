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
        ->fill('@new-link', 'https://home.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'do smth')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'clean the sheet')
        ->click('@submit-new-step-button')
        ->click('Create')
        ->assertPathIs('/ideas');

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title'       => 'some example',
        'status'      => 'completed',
        'description' => 'some example description',
        'links'       => ['https://youtube.com', 'https://home.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});
