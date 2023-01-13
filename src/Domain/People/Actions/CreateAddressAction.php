<?php

namespace Domain\People\Actions;

use Domain\People\Actions\Contracts\CreateAddressActionInterface;
use Domain\People\DataTransferObjects\AddressData;
use Domain\People\Models\Address;

class CreateAddressAction implements CreateAddressActionInterface
{
    public function execute(AddressData $data): Address
    {
        return Address::create([
            'person_id' => $data->person->id,
            'address_line' => $data->address_line,
            'country' => $data->country,
            'region' => $data->region,
            'town_city' => $data->town_city,
            'postal_code' => $data->postal_code
        ]);
    }
}
