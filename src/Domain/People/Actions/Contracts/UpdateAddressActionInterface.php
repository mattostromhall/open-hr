<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;

interface UpdateAddressActionInterface
{
    public function execute(Address $address, AddressData $data): bool;
}
