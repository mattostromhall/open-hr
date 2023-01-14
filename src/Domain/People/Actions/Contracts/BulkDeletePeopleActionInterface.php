<?php

namespace Domain\People\Actions\Contracts;

interface BulkDeletePeopleActionInterface
{
    /**
     * @param array<int> $people
     * @return bool
     */
    public function execute(array $people): bool;
}
