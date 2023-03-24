<?php

use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use function Pest\Faker\fake;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('impersonates the requested user', function () {
    $this->person->assign(Role::ADMIN);
    $impersonate = Person::factory()->create();

    expect(auth()->id())->toBe($this->person->user->id);

    $this->post(route('user.impersonate.store'), [
        'id' => $impersonate->user->id
    ])
        ->assertStatus(302)
        ->assertSessionHas('impersonator', $this->person->user->id);

    expect(auth()->id())->toBe($impersonate->user->id);
});

it('returns unauthorized if the person does not have permission to impersonate', function () {
    $this->person->assign(Role::PERSON);
    $impersonate = Person::factory()->create();

    expect(auth()->id())->toBe($this->person->user->id);

    $this->post(route('user.impersonate.store'), [
        'id' => $impersonate->user->id
    ])
        ->assertForbidden();

    expect(auth()->id())->toBe($this->person->user->id);
});

it('cancels the impersonation', function () {
    $this->person->assign(Role::ADMIN);
    $impersonate = Person::factory()->create();

    $this->post(route('user.impersonate.store'), [
        'id' => $impersonate->user->id
    ])
        ->assertStatus(302)
        ->assertSessionHas('impersonator', $this->person->user->id);

    $this->delete(route('user.impersonate.destroy'))
        ->assertSessionMissing('impersonator');

    expect(auth()->id())->toBe($this->person->user->id);
});
