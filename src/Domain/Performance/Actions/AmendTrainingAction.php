<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class AmendTrainingAction
{
    public function __construct(
        protected UpdateTrainingAction $updateTraining,
        protected RequestTrainingReviewAction $requestReview
    ) {
        //
    }

    public function execute(Training $training, TrainingData $data): bool
    {
        $updated = $this->updateTraining->execute($training, $data);

        if ($updated) {
            $this->requestReview->execute($training, $data);
        }

        return $updated;
    }
}
