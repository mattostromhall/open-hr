<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Models\Objective;

class DeleteObjectiveAction
{
    public function execute(Objective $objective): bool
    {
        return $objective->delete();
    }
}
