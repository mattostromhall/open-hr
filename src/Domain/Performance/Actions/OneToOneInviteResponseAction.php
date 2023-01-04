<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Mail\OneToOneInviteResponse;
use Domain\Performance\Models\OneToOne;
use Illuminate\Support\Facades\Mail;

class OneToOneInviteResponseAction
{
    public function __construct(
        protected UpdateOneToOneAction $updateOneToOne,
        protected CreateNotificationAction $createNotification
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

        Mail::to($requester->user->email)
            ->send(new OneToOneInviteResponse($oneToOne, $data));

        Mail::to($requested->user->email)
            ->send(new OneToOneInviteResponse($oneToOne, $data));
    }

    protected function status(OneToOneStatus $status): string
    {
        if ($status->value === 1) {
            return 'amended';
        }

        return $status->statusDisplay();
    }
}
