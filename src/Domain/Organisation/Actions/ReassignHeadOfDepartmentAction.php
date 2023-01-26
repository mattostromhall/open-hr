<?php

namespace Domain\Organisation\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Organisation\Actions\Contracts\ReassignHeadOfDepartmentActionInterface;
use Domain\Organisation\Models\Department;

class ReassignHeadOfDepartmentAction implements ReassignHeadOfDepartmentActionInterface
{
    public function __construct(protected CreateNotificationActionInterface $createNotification)
    {
        //
    }

    public function execute(Department $department, int $newHeadOfDepartmentId): bool
    {
        $updated = $department->update([
            'head_of_department_id' => $newHeadOfDepartmentId
        ]);

        if ($updated) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "You have been assigned as Head of Department for {$department->name}",
                    notifiable_id: $newHeadOfDepartmentId,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Head of Department',
                )
            );
        }

        return $updated;
    }
}
