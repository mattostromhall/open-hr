<?php

namespace Domain\People\DataTransferObjects;

use Domain\People\Models\Person;
use Support\DataTransferObjects\DataTransferObject;

class AddressData extends DataTransferObject
{
    public function __construct(
        public readonly Person|null $person,
        public readonly string $address_line,
        public readonly string $town_city,
        public readonly string $region,
        public readonly string $country,
        public readonly string $postal_code
    ) {
        //
    }
}
