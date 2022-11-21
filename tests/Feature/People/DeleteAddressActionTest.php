<?php

use Domain\Auth\Models\User;
use Domain\People\Actions\DeleteAddressAction;
use Domain\People\Actions\UpdateAddressAction;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;
use Domain\People\Models\Person;

it('deletes the address', function () {
    $address = Address::factory()->create();
    $action = app(DeleteAddressAction::class);

    $this->assertNotSoftDeleted($address);

    $action->execute($address);

    $this->assertSoftDeleted($address);
});
