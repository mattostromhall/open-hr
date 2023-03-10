<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Performance\Actions\Contracts\StartTrainingActionInterface;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Models\Training;

class StartTrainingAction implements StartTrainingActionInterface
{
    public function execute(Training $training): bool
    {
        return $training->update([
            'state' => TrainingState::STARTED
        ]);
    }
}
