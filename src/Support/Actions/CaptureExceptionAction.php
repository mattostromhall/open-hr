<?php

namespace Support\Actions;

use Domain\Notifications\Actions\SendEmailNotificationAction;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Exception;
use Support\DataTransferObjects\ExceptionLogData;
use Support\Models\ExceptionLog;

class CaptureExceptionAction
{
    public function __construct(
        protected SendEmailNotificationAction $sendEmail,
        protected CreateExceptionLogAction $createExceptionLog
    ) {
        //
    }

    public function execute(Exception $e): ExceptionLog
    {
        $exceptionLog = $this->createExceptionLog->execute(ExceptionLogData::fromException($e));

        if (config('hr.sys_admin')) {
            $this->sendEmail->execute(
                new EmailNotificationData(
                    recipients: [config('hr.sys_admin')],
                    subject: 'An Error Occurred',
                    body: "Error with hash {$exceptionLog->hash} has occurred."
                )
            );
        }

        return $exceptionLog;
    }
}
