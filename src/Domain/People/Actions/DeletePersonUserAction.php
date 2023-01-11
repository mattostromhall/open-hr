<?php

namespace Domain\People\Actions;

use Domain\Auth\Actions\Contracts\DeleteUserActionInterface;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;

class DeletePersonUserAction
{
    public function __construct(protected DeletePersonAction $deletePerson, protected DeleteUserActionInterface $deleteUser)
    {
        //
    }

    public function execute(Person $person, User $user): bool
    {
        return $this->deletePerson->execute($person)
            && $this->deleteUser->execute($user);
    }
}
