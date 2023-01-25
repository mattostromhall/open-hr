<?php

namespace Domain\People\Actions;

use Domain\People\Actions\Contracts\ReassignManagerFromPersonActionInterface;
use Domain\People\Models\Person;

class ReassignManagerFromPersonAction implements ReassignManagerFromPersonActionInterface
{
    public function execute(Person $person, int $newManagerId): bool
    {
        // TODO: Implement execute() method.
    }
}
