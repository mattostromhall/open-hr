<?php

namespace Domain\People\Actions;

use Domain\People\Models\Address;

class DeleteAddressAction
{
    public function execute(Address $address): bool
    {
        return $address->delete();
    }
}
