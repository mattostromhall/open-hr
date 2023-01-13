<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

interface AmendObjectiveActionInterface
{
    public function execute(Objective $objective, ObjectiveData $data): bool;
}
