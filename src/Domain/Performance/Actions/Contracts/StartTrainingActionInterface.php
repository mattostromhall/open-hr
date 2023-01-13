<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\Models\Training;

interface StartTrainingActionInterface
{
    public function execute(Training $training): bool;
}
