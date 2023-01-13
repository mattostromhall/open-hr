<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\AmendTrainingActionInterface;
use Domain\Performance\Actions\Contracts\RequestTrainingReviewActionInterface;
use Domain\Performance\Actions\Contracts\UpdateTrainingActionInterface;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class AmendTrainingAction implements AmendTrainingActionInterface
{
    public function __construct(
        protected UpdateTrainingActionInterface $updateTraining,
        protected RequestTrainingReviewActionInterface $requestReview
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
