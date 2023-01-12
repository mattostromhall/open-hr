<?php

namespace Domain\Notifications\Actions\Contracts;

use Domain\Notifications\DataTransferObjects\EmailNotificationData;

interface SendEmailNotificationActionInterface
{
    public function execute(EmailNotificationData $data): void;
}
