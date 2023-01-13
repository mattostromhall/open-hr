<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\Objective;

interface CompleteObjectiveActionInterface
{
    public function execute(Objective $objective): bool;
}
