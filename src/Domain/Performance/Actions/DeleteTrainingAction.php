<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\DeleteTrainingActionInterface;
use Domain\Performance\Models\Training;

class DeleteTrainingAction implements DeleteTrainingActionInterface
{
    public function execute(Training $training): bool
    {
        return $training->delete();
    }
}
