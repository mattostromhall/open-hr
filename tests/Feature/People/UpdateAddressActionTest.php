<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\UpdateAddressAction;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;
use Domain\People\Models\Person;

it('creates an address', function () {
    $user = User::factory()->create();
    $person = Person::factory()
        ->for($user)
        ->create();
    $address = Address::factory()
        ->for($person)
        ->create();
    $action = app(UpdateAddressAction::class);
    $addressData = new AddressData(
        person: $person,
        address_line: '1 Test Close',
        town_city: 'Town',
        region: 'Region',
        country: 'Test',
        postal_code: 'AB1 2CD'
    );

    $action->execute($address, $addressData);

    $this->assertDatabaseHas('addresses', [
        'person_id' => $address->person_id,
        'address_line' => '1 Test Close',
        'town_city' => 'Town',
        'region' => 'Region',
        'country' => 'Test',
        'postal_code' => 'AB1 2CD'
    ]);
});
