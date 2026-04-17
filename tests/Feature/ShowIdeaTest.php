<?php

use App\Models\Idea;
use App\Models\User;
it('must be signed in to see an idea', function () {
    $idea = Idea::factory()->create();

    $this->get(route('idea.show', $idea))->assertRedirectToRoute('login');
});

it('disallws accessing an idea you did not create', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $idea = Idea::factory()->create();
    $this->get(route('idea.show', $idea))->assertForbidden();
});
