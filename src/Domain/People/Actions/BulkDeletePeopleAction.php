<?php

namespace Domain\People\Actions;

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
        return Person::query()
            ->whereIn('id', $people)
            ->delete();
    }
}
