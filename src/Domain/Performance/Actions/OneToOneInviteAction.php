<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\Actions\Contracts\OneToOneInviteActionInterface;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Models\OneToOne;

class OneToOneInviteAction implements OneToOneInviteActionInterface
{
    public function __construct(
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(OneToOne $oneToOne, OneToOneData $data): void
    {
        $requester = $oneToOne->requester;
        $requested = $oneToOne->requested();

        $this->createNotification->execute(
            new NotificationData(
                body: "A One-to-one has been requested by {$requester->full_name} at {$data->scheduled_at->toDateTimeString()}",
                notifiable_id: $requested->id,
                notifiable_type: NotifiableType::PERSON,
                title: 'A One-to-one has been requested',
                link: route('one-to-one.invite.show', [
                    'one_to_one' => $oneToOne
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$requested->email],
                subject: 'A One-to-one has been requested',
                body: "A One-to-one has been requested by {$requester->full_name} at {$data->scheduled_at->toDateTimeString()}",
                link: route('one-to-one.invite.show', [
                    'one_to_one' => $oneToOne
                ])
            )
        );
    }
}
