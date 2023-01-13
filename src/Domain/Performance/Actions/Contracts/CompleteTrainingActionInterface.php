<?php

namespace Domain\Performance\Actions\Contracts;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Models\Training;

interface CompleteTrainingActionInterface
{
    public function execute(Training $training): bool;
}
