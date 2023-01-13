<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;

interface CreateAddressActionInterface
{
    public function execute(AddressData $data): Address;
}
