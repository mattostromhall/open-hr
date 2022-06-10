<?php

namespace Domain\People\Actions;

use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;

class UpdateAddressAction
{
    public function execute(Address $address, AddressData $data): bool
    {
        return $address->update([
            'address_line' => $data->address_line,
            'country' => $data->country,
            'region' => $data->region,
            'town_city' => $data->town_city,
            'postal_code' => $data->postal_code
        ]);
    }
}
