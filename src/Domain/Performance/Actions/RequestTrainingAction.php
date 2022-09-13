<?php

namespace Domain\Performance\Actions;

use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class RequestTrainingAction
{
    public function __construct(
        protected CreateTrainingAction $createTraining,
        protected RequestTrainingReviewAction $requestReview
    ) {
        //
    }

    public function execute(TrainingData $data): Training
    {
        $training = $this->createTraining->execute($data);

        $this->requestReview->execute($training, $data);

        return $training;
    }
}
