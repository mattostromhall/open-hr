<?php

use Domain\Auth\Enums\Role;
use Domain\Notifications\Models\Notification;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $this->organisation = Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('returns the organisation notifications index', function () {
    Notification::factory()->count(3)->create([
        'notifiable_id' => $this->organisation->id,
        'notifiable_type' => 'organisation'
    ]);

    $this->get(route('organisation.notifications'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Organisation/Notifications/Index')
                ->has('organisationNotifications', 3)
        );
});

it('returns the organisation notification create page', function () {
    $this->person->assign(Role::ADMIN);

    $this->get(route('organisation.notification.create'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page->component('Organisation/Notifications/Create')
        );
});

it('returns unauthorized when creating if the person does not have permission to create an organisation notification', function () {
    $this->get(route('organisation.notification.create'))
        ->assertForbidden();
});

it('creates a new organisation notification when the correct data is provided', function () {
    $this->person->assign(Role::ADMIN);

    $response = $this->post(route('organisation.notification.store'), [
        'title' => 'Notification title',
        'body' => 'This is a notification for the organisation',
        'link' => 'https://open-hr.test'
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Organisation notification successfully created!');
});

it('returns unauthorized if the person does not have permission to create an organisation notification', function () {
    $response = $this->post(route('organisation.notification.store'), [
        'title' => 'Notification title',
        'body' => 'This is a notification for the organisation',
        'link' => 'https://open-hr.test'
    ]);

    $response->assertForbidden();
});

it('returns validation errors when creating a new organisation notification with incorrect data', function () {
    $response = $this->post(route('organisation.notification.store'), [
        'body' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['body']);
});
