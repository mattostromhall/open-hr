<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\PersonProfileData;
use Domain\People\Models\Person;

interface UpdatePersonProfileActionInterface
{
    public function execute(Person $person, PersonProfileData $data): bool;
}
