<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Models\Person;

interface UpdatePersonActionInterface
{
    public function execute(Person $person, PersonData $data): bool;
}
