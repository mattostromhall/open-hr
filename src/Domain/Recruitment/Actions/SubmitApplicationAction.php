<?php

namespace Domain\Recruitment\Actions;

use Domain\Expenses\Models\Expense;
use Domain\Files\Actions\UploadDocumentAction;
use Domain\Files\DataTransferObjects\DocumentData;
use Domain\Files\DataTransferObjects\UploadedDocumentData;
use Domain\Files\DataTransferObjects\UploadedFileData;
use Domain\Files\Enums\DocumentableType;
use Domain\Notifications\Actions\CreateNotificationAction;
use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Domain\Notifications\DataTransferObjects\NotificationData;
use Domain\Recruitment\DataTransferObjects\SubmittedApplicationData;
use Domain\Recruitment\Models\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class SubmitApplicationAction
{
    public function __construct(
        protected CreateApplicationAction $createApplication,
        protected UploadDocumentAction $uploadCV,
        protected CreateNotificationAction $createNotification,
        protected SendEmailNotificationAction $sendEmail
    ) {
        //
    }

    public function execute(SubmittedApplicationData $data): Application
    {
        $application = $this->createApplication->execute($data->application_data);

        $this->uploadCV->execute($this->uploadedCV($data->cv, $application));

        $this->createNotification->execute(
            new NotificationData(
                body: "A new Application has been submitted for - {$data->application_data->vacancy->title}.",
                notifiable_id: $data->application_data->vacancy->contact->id,
                notifiable_type: 'person',
                title: 'New Application',
                link: route('vacancy.show', [
                    'vacancy' => $data->application_data->vacancy
                ])
            )
        );

        $this->sendEmail->execute(
            new EmailNotificationData(
                recipients: [$data->application_data->vacancy->contact->user->email],
                subject: 'New Application',
                body: "A new Application has been submitted for - {$data->application_data->vacancy->title}, click here to review.",
                link: route('vacancy.show', [
                    'vacancy' => $data->application_data->vacancy
                ])
            )
        );

        return $application;
    }

    protected function uploadedCV(UploadedFile $cv, Application $application): UploadedDocumentData
    {
        return UploadedDocumentData::from([
                new UploadedFileData(
                    file: $cv,
                    path: "/documents/applications/{$application->id}",
                    name: Str::beforeLast($cv->getClientOriginalName(), '.')
                ),
                new DocumentData(
                    name: Str::beforeLast($cv->getClientOriginalName(), '.'),
                    directory: "/documents/applications/{$application->id}",
                    size: $cv->getSize(),
                    extension: $cv->extension(),
                    disk: config('filesystems.default'),
                    documentable_id: $application->id,
                    documentable_type: DocumentableType::APPLICATION
                )
            ]);
    }
}