<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

interface RequestTrainingActionInterface
{
    public function execute(TrainingData $data): Training;
}
