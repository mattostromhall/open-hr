<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\Models\Person;

interface DeletePersonActionInterface
{
    public function execute(Person $person): bool;
}
