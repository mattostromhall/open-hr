<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

interface CreateOneToOneRecurrenceActionInterface
{
    public function execute(OneToOneData $data): ?OneToOne;
}
