<?php

namespace Domain\People\Actions;

use Domain\People\Models\Person;

class DeletePersonAction
{
    public function execute(Person $person): bool
    {
        return $person->delete();
    }
}
