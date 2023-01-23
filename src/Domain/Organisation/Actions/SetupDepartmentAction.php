<?php

namespace Domain\Organisation\Actions;

use Domain\Files\Actions\Contracts\CreateDirectoryActionInterface;
use Domain\Notifications\Actions\Contracts\CreateNotificationActionInterface;
use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Notifications\Enums\NotifiableType;
use Domain\Organisation\Actions\Contracts\CreateDepartmentActionInterface;
use Domain\Organisation\Actions\Contracts\SetupDepartmentActionInterface;
use Domain\Organisation\DataTransferObjects\DepartmentData;
use Domain\Organisation\Models\Department;

class SetupDepartmentAction implements SetupDepartmentActionInterface
{
    public function __construct(
        protected CreateDepartmentActionInterface $createDepartment,
        protected CreateDirectoryActionInterface $createDirectory,
        protected CreateNotificationActionInterface $createNotification,
        protected SendEmailNotificationActionInterface $sendEmail
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
                notifiable_type: NotifiableType::PERSON,
                title: 'Assigned as Head of Department',
                link: route('department.show', [
                    'department' => $department
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$data->head_of_department->email],
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
