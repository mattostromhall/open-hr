<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\Models\Person;

interface ReassignManagerFromPersonActionInterface
{
    public function execute(Person $person, int $newManagerId): bool;
}
