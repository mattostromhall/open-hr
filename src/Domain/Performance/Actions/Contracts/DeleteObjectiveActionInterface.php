<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\Objective;

interface DeleteObjectiveActionInterface
{
    public function execute(Objective $objective): bool;
}
