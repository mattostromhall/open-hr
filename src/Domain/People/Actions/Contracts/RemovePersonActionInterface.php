<?php

namespace Domain\People\Actions\Contracts;

use Domain\People\DataTransferObjects\RemovePersonData;

interface RemovePersonActionInterface
{
    public function execute(RemovePersonData $data): bool;
}
