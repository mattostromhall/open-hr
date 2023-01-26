<?php

namespace Domain\People\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\People\Actions\Contracts\ReassignManagerFromPersonActionInterface;
use Domain\People\Models\Person;

class ReassignManagerFromPersonAction implements ReassignManagerFromPersonActionInterface
{
    public function __construct(protected CreateNotificationActionInterface $createNotification)
    {
        //
    }

    public function execute(Person $person, ?int $newManagerId = null): bool
    {
        $directReportNames = $person
            ->directReports
            ->pluck('full_name')
            ->join(', ');

        $updated = $person
            ->directReports()
            ->update([
                'manager_id' => $newManagerId
            ]);

        if ($updated && $newManagerId) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "You have been assigned {$directReportNames} as Direct Reports",
                    notifiable_id: $newManagerId,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'New Direct Reports',
                )
            );
        }

        return $updated;
    }
}
