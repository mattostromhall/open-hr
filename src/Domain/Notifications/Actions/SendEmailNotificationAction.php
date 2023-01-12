<?php

namespace Domain\Notifications\Actions;

use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\Mail\EmailNotification;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationAction implements SendEmailNotificationActionInterface
{
    public function execute(EmailNotificationData $data): void
    {
        Mail::to($data->recipients)
            ->send(new EmailNotification($data));
    }
}
