<?php

namespace Domain\Performance\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Performance\DataTransferObjects\OneToOneData;
use Domain\Performance\Mail\OneToOneInvite;
use Domain\Performance\Models\OneToOne;
use Illuminate\Support\Facades\Mail;

class OneToOneInviteAction
{
    public function __construct(protected CreateNotificationAction $createNotification)
    {
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

        Mail::to($requested->user->email)
            ->send(new OneToOneInvite($oneToOne, $data));
    }
}
