<?php

namespace Domain\People\DataTransferObjects;

use Domain\People\Models\Person;

class AddressData
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

    public static function from(array $data): self
    {
        return new self(...$data);
    }
}
