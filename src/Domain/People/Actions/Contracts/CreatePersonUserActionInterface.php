<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\PersonUserData;

interface CreatePersonUserActionInterface
{
    public function execute(PersonUserData $data): array;
}
