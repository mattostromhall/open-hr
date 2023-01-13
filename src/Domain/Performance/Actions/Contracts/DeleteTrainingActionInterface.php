<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\Training;

interface DeleteTrainingActionInterface
{
    public function execute(Training $training): bool;
}
