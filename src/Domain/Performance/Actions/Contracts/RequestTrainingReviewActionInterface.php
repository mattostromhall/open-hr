<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

interface RequestTrainingReviewActionInterface
{
    public function execute(Training $training, TrainingData $data): void;
}
