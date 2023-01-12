<?php

namespace Domain\Organisation\Actions;

use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Organisation\Actions\Contracts\AmendDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\UpdateDepartmentActionInterface;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

class AmendDepartmentAction implements AmendDepartmentActionInterface
{
    public function __construct(
        protected UpdateDepartmentActionInterface $updateDepartment,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
    ) {
        //
    }

    public function execute(Department $department, DepartmentData $data): bool
    {
        $newHeadOfDepartment = $department->head_of_department_id !== $data->head_of_department->id;
        $updated = $this->updateDepartment->execute($department, $data);

        if ($updated && $newHeadOfDepartment) {
            $this->createNotification->execute(
                new NotificationData(
                    body: "You have been made the Head of Department for {$data->name}",
                    notifiable_id: $data->head_of_department->id,
                    notifiable_type: NotifiableType::PERSON,
                    title: 'Assigned as Head of Department',
                    link: route('department.show', [
                        'department' => $department
                    ])
                )
            );

            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [$data->head_of_department->user->email],
                    subject: 'Assigned as Head of Department',
                    body: "You have been made the Head of Department for {$data->name}",
                    link: route('department.show', [
                        'department' => $department
                    ])
                )
            );
        }

        return $updated;
    }
}
