<?php

use Domain\Auth\Enums\Role;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Address;
use Domain\People\Models\Person;
use function Pest\Faker\faker;

beforeEach(function () {
    Organisation::factory()->create();
    $this->person = Person::factory()->create();
    $this->actingAs($this->person->user);
});

it('creates a new address when the correct data is provided', function () {
    $this->person->assign(Role::PERSON);

    $response = $this->post(route('address.store', ['person' => $this->person]), [
        'address_line' => faker()->streetAddress(),
        'country' => faker()->country(),
        'region' => faker()->text(10),
        'town_city' => faker()->city(),
        'postal_code' => faker()->postcode()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Address successfully created!');
});

it('returns unauthorized if the person does not have permission to create an address', function () {
    $response = $this->post(route('address.store', ['person' => $this->person]), [
        'address_line' => faker()->streetAddress(),
        'country' => faker()->country(),
        'region' => faker()->text(10),
        'town_city' => faker()->city(),
        'postal_code' => faker()->postcode()
    ]);

    $response->assertForbidden();
});

it('returns validation errors when creating a new address with incorrect data', function () {
    $response = $this->post(route('address.store', ['person' => $this->person]), [
        'address_line' => null,
        'country' => null,
        'region' => null,
        'town_city' => null,
        'postal_code' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['address_line', 'country', 'region', 'town_city', 'postal_code']);
});

it('updates the address when the correct data is provided', function () {
    $this->person->assign(Role::PERSON);
    $address = Address::factory()->for($this->person)->create();

    $response = $this->put(route('address.update', ['address' => $address]), [
        'address_line' => faker()->streetAddress(),
        'country' => faker()->country(),
        'region' => faker()->text(10),
        'town_city' => faker()->city(),
        'postal_code' => faker()->postcode()
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Address successfully updated!');
});

it('returns unauthorized if the person does not have permission to update the address', function () {
    $address = Address::factory()->create();

    $response = $this->put(route('address.update', ['address' => $address]), [
        'address_line' => faker()->streetAddress(),
        'country' => faker()->country(),
        'region' => faker()->text(10),
        'town_city' => faker()->city(),
        'postal_code' => faker()->postcode()
    ]);

    $response->assertForbidden();
});

it('returns validation errors when updating the address with incorrect data', function () {
    $address = Address::factory()->create();

    $response = $this->put(route('address.update', ['address' => $address]), [
        'address_line' => null,
        'country' => null,
        'region' => null,
        'town_city' => null,
        'postal_code' => null
    ]);

    $response
        ->assertStatus(302)
        ->assertSessionHasErrors(['address_line', 'country', 'region', 'town_city', 'postal_code']);
});

it('deletes the address', function () {
    $this->person->assign(Role::PERSON);
    $address = Address::factory()->for($this->person)->create();

    $response = $this->delete(route('address.destroy', ['address' => $address]));

    $response
        ->assertStatus(302)
        ->assertSessionHas('flash.success', 'Address deleted!');
});

it('returns unauthorized if the person does not have permission to delete the address', function () {
    $address = Address::factory()->create();

    $response = $this->delete(route('address.destroy', ['address' => $address]));

    $response->assertForbidden();
});
