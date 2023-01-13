<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\Models\Address;

interface DeleteAddressActionInterface
{
    public function execute(Address $address): bool;
}
