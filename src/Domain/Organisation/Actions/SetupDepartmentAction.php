<?php

namespace Domain\Organisation\Actions;

use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

class SetupDepartmentAction
{
    public function __construct(
        protected CreateDepartmentAction $createDepartment,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(DepartmentData $data): Department
    {
        $department = $this->createDepartment->execute($data);

        $this->createNotification->execute(
            new NotificationData(
                body: "You have been made the Head of Department for {$data->name}",
                notifiable_id: $data->head->id,
                notifiable_type: 'person',
                title: 'Assigned as Head of Department',
                link: route('department.show', [
                    'department' => $department
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$data->head->user->email],
                subject: 'Assigned as Head of Department',
                body: "You have been made the Head of Department for {$data->name}",
                link: route('department.show', [
                    'department' => $department
                ])
            )
        );

        return $department;
    }
}
