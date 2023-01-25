<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\DeletePersonData;

interface DeletePersonUserActionInterface
{
    public function execute(DeletePersonData $data): bool;
}
