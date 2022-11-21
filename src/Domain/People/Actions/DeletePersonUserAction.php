<?php

namespace Domain\People\Actions;

use Domain\Auth\Actions\DeleteUserAction;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;

class DeletePersonUserAction
{
    public function __construct(protected DeletePersonAction $deletePerson, protected DeleteUserAction $deleteUser)
    {
        //
    }

    public function execute(Person $person, User $user): bool
    {
        return $this->deletePerson->execute($person)
            && $this->deleteUser->execute($user);
    }
}
