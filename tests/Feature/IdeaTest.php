<?php

use App\Models\Idea;
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
        'title' => 'some example',
        'status' => 'completed',
        'description' => 'some example description',
        'links' => ['https://youtube.com', 'https://home.com'],
    ]);

    expect($idea->steps)->toHaveCount(2);
});

it('edits an existing new idea', function () {
    $this->actingAs($user = User::factory()->create());

    $idea = Idea::factory()->for($user)->create();

    visit(route('idea.show', $idea))
        ->click('@edit-idea-button')
        ->fill('title', 'some example')
        ->click("@button-status-completed")
        ->fill('description', 'some example description')
        ->fill('@new-link', 'https://youtube.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'clean the sheet')
        ->click('@submit-new-step-button')
        ->click('Update')
        ->assertRoute('idea.show', [$idea]);

    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'some example',
        'status' => 'completed',
        'description' => 'some example description',
        'links' => [$idea->links[0],'https://youtube.com'],
    ]);

    expect($idea->steps)->toHaveCount(1);
});
