<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\ObjectiveData;
use Domain\Performance\Models\Objective;

interface SetObjectiveActionInterface
{
    public function execute(ObjectiveData $data): Objective;
}
