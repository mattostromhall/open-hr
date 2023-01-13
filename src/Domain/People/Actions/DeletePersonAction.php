<?php

namespace Domain\People\Actions;

use Domain\People\Actions\Contracts\DeletePersonActionInterface;
use Domain\People\Models\Person;

class DeletePersonAction implements DeletePersonActionInterface
{
    public function execute(Person $person): bool
    {
        return $person->delete();
    }
}
