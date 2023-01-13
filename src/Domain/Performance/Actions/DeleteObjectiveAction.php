<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\DeleteObjectiveActionInterface;
use Domain\Performance\Models\Objective;

class DeleteObjectiveAction implements DeleteObjectiveActionInterface
{
    public function execute(Objective $objective): bool
    {
        return $objective->delete();
    }
}
