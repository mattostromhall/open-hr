<?php

namespace Domain\People\Actions;

use Domain\People\Actions\Contracts\DeleteAddressActionInterface;
use Domain\People\Models\Address;

class DeleteAddressAction implements DeleteAddressActionInterface
{
    public function execute(Address $address): bool
    {
        return $address->delete();
    }
}
