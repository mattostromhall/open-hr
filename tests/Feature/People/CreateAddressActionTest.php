<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\CreateAddressAction;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Person;

it('creates an address', function () {
    $user = User::factory()->create();
    $person = Person::factory()
        ->for($user)
        ->create();
    $action = app(CreateAddressAction::class);
    $addressData = new AddressData(
        person: $person,
        address_line: '1 Test Close',
        town_city: 'Town',
        region: 'Region',
        country: 'Test',
        postal_code: 'AB1 2CD'
    );

    $action->execute($addressData);

    $this->assertDatabaseHas('addresses', [
        'person_id' => $addressData->person->id,
        'address_line' => '1 Test Close',
        'town_city' => 'Town',
        'region' => 'Region',
        'country' => 'Test',
        'postal_code' => 'AB1 2CD'
    ]);
});
