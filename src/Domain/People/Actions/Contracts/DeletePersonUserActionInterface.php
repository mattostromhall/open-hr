<?php

namespace Domain\People\Actions\Contracts;

use Domain\Auth\Models\User;
use Domain\People\Models\Person;

interface DeletePersonUserActionInterface
{
    public function execute(Person $person, User $user): bool;
}
