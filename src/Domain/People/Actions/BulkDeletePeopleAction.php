<?php

namespace Domain\People\Actions;

use Domain\Auth\Models\User;
use Domain\People\Actions\Contracts\BulkDeletePeopleActionInterface;
use Domain\People\Models\Person;

class BulkDeletePeopleAction implements BulkDeletePeopleActionInterface
{
    /**
     * @param array<int> $people
     * @return bool
     */
    public function execute(array $people): bool
    {
        $usersDeleted = User::query()
            ->whereIn('id', $people)
            ->delete();

        $peopleDeleted = Person::query()
            ->whereIn('user_id', $people)
            ->delete();

        return $usersDeleted && $peopleDeleted;
    }
}
