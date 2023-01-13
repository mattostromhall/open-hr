<?php

namespace Domain\Performance\Actions;

use Domain\Performance\Actions\Contracts\CreateTrainingActionInterface;
use Domain\Performance\Actions\Contracts\RequestTrainingActionInterface;
use Domain\Performance\Actions\Contracts\RequestTrainingReviewActionInterface;
use Domain\Performance\DataTransferObjects\TrainingData;
use Domain\Performance\Models\Training;

class RequestTrainingAction implements RequestTrainingActionInterface
{
    public function __construct(
        protected CreateTrainingActionInterface $createTraining,
        protected RequestTrainingReviewActionInterface $requestReview
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
