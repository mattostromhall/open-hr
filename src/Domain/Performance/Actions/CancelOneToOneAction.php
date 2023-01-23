<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Actions\Contracts\CancelOneToOneActionInterface;
use Domain\Performance\Actions\Contracts\DeleteOneToOneActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class CancelOneToOneAction implements CancelOneToOneActionInterface
{
    public function __construct(
        protected DeleteOneToOneActionInterface $deleteOneToOne,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(OneToOne $oneToOne, OneToOneData $data): bool
    {
        $deleted = $this->deleteOneToOne->execute($oneToOne);

        if ($deleted) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "One-to-one scheduled at {$data->scheduled_at->toDateString()} has been cancelled.",
                    notifiable_id: $data->person->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'One-to-one cancelled',
                )
            );

            $this->createNotification->execute(
                new NotificationData(
                    body: "One-to-one scheduled at {$data->scheduled_at->toDateString()} has been cancelled.",
                    notifiable_id: $data->manager->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'One-to-one cancelled',
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$data->person->email],
                    subject: 'One-to-one cancelled',
                    body: "One-to-one scheduled at {$data->scheduled_at->toDateString()} has been cancelled."
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$data->manager->email],
                    subject: 'One-to-one cancelled',
                    body: "One-to-one scheduled at {$data->scheduled_at->toDateString()} has been cancelled."
                )
            );
        }

        return $deleted;
    }
}
