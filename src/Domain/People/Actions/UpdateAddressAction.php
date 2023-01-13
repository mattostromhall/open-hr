<?php

namespace Domain\People\Actions;

use Domain\People\Actions\Contracts\UpdateAddressActionInterface;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;

class UpdateAddressAction implements UpdateAddressActionInterface
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
