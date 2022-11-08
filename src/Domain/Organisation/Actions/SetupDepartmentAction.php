<?php

namespace Domain\Organisation\Actions;

use Domain\Files\Actions\CreateDirectoryAction;
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
        protected CreateDirectoryAction $createDirectory,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(DepartmentData $data): Department
    {
        $department = $this->createDepartment->execute($data);

        $this->createDirectory->execute('documents/departments/' . $data->name);

        $this->createNotification->execute(
            new NotificationData(
                body: "You have been made the Head of Department for {$data->name}",
                notifiable_id: $data->head_of_department->id,
                notifiable_type: 'person',
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

        return $department;
    }
}
