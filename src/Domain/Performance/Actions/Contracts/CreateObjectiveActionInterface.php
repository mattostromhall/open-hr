<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

interface CreateObjectiveActionInterface
{
    public function execute(ObjectiveData $data): Objective;
}
