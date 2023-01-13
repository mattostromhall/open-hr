<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\PersonData;
use Domain\People\Models\Person;

interface CreatePersonActionInterface
{
    public function execute(PersonData $data): Person;
}
