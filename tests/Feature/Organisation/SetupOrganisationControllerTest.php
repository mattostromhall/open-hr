<?php

use Domain\Auth\Models\User;
use Domain\Organisation\Models\Department;
use Illuminate\Http\UploadedFile;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('sets up the organisation', function () {
    $this->get(route('setup.index'));

    $response = $this->post(route('setup.organisation'), [
        'name' => 'Open HR',
        'logo' => UploadedFile::fake()->create('logo.png', 10)
    ]);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('setup.index'));
});
