<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Actions\Contracts\OneToOneInviteResponseActionInterface;
use Domain\Performance\Actions\Contracts\UpdateOneToOneActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Models\OneToOne;

class OneToOneInviteResponseAction implements OneToOneInviteResponseActionInterface
{
    public function __construct(
        protected UpdateOneToOneActionInterface $updateOneToOne,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(OneToOne $oneToOne, OneToOneData $data): void
    {
        $updated = $this->updateOneToOne->execute($oneToOne, $data);

        if (! $updated) {
            return;
        }

        $requester = $oneToOne->requester;
        $requested = $oneToOne->requested();

        $this->createNotification->execute(
            new NotificationData(
                body: "A One-to-one between {$requester->full_name} and {$requested->full_name}, scheduled at {$data->scheduled_at->toDateTimeString()}, has been {$this->status($oneToOne->status)}",
                notifiable_id: $requester->id,
                notifiable_type: NotifiableType::PERSON,
                title: "A One-to-one has been {$this->status($oneToOne->status)}",
                link: route('one-to-one.invite.show', [
                    'one_to_one' => $oneToOne
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$requester->email],
                subject: "A One-to-one has been {$this->status($oneToOne->status)}",
                body: "A One-to-one between {$requester->full_name} and {$requested->full_name}, scheduled at {$data->scheduled_at->toDateTimeString()}, has been {$this->status($oneToOne->status)}",
                link: route('one-to-one.invite.show', [
                    'one_to_one' => $oneToOne
                ])
            )
        );

        $this->createNotification->execute(
            new NotificationData(
                body: "A One-to-one between {$requester->full_name} and {$requested->full_name}, scheduled at {$data->scheduled_at->toDateTimeString()}, has been {$this->status($oneToOne->status)}",
                notifiable_id: $requested->id,
                notifiable_type: NotifiableType::PERSON,
                title: "A One-to-one has been {$this->status($oneToOne->status)}",
                link: route('one-to-one.invite.show', [
                    'one_to_one' => $oneToOne
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$requested->email],
                subject: "A One-to-one has been {$this->status($oneToOne->status)}",
                body: "A One-to-one between {$requester->full_name} and {$requested->full_name}, scheduled at {$data->scheduled_at->toDateTimeString()}, has been {$this->status($oneToOne->status)}",
                link: route('one-to-one.invite.show', [
                    'one_to_one' => $oneToOne
                ])
            )
        );
    }

    protected function status(OneToOneStatus $status): string
    {
        if ($status->value === 1) {
            return 'amended';
        }

        return $status->statusDisplay();
    }
}
