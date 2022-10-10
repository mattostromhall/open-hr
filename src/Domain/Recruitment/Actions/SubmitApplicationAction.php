<?php

namespace Domain\Recruitment\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Recruitment\DataTransferObjects\ApplicationData;
use Domain\Recruitment\Models\Application;

class SubmitApplicationAction
{
    public function __construct(
        protected CreateApplicationAction $createApplication,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(ApplicationData $data): Application
    {
        $application = $this->createApplication->execute($data);

        $this->createNotification->execute(
            new NotificationData(
                body: "A new Application has been submitted for - {$data->vacancy->title}.",
                notifiable_id: $data->vacancy->contact->id,
                notifiable_type: 'person',
                title: 'New Application',
                link: route('vacancy.show', [
                    'vacancy' => $data->vacancy
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$data->vacancy->contact->user->email],
                subject: 'New Application',
                body: "A new Application has been submitted for - {$data->vacancy->title}, click here to review.",
                link: route('vacancy.show', [
                    'vacancy' => $data->vacancy
                ])
            )
        );

        return $application;
    }
}
