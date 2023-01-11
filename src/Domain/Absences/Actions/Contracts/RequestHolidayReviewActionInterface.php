<?php

namespace Domain\Absences\Actions\Contracts;

use Domain\Absences\DataTransferObjects\HolidayData;
use Domain\Absences\Mail\ReviewHolidayRequest;
use Domain\Absences\Models\Holiday;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Illuminate\Support\Facades\Mail;

interface RequestHolidayReviewActionInterface
{
    public function execute(Holiday $holiday, HolidayData $data): void;
}
