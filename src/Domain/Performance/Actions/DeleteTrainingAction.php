<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Models\Training;

class DeleteTrainingAction
{
    public function execute(Training $training): bool
    {
        return $training->delete();
    }
}
