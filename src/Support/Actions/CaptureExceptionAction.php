<?php

namespace Support\Actions;

use Domain\Notifications\Actions\Contracts\SendEmailNotificationActionInterface;
use Domain\Notifications\DataTransferObjects\EmailNotificationData;
use Exception;
use Support\Actions\Contracts\CaptureExceptionActionInterface;
use Support\Actions\Contracts\CreateExceptionLogActionInterface;
use Support\DataTransferObjects\ExceptionLogData;
use Support\Models\ExceptionLog;

class CaptureExceptionAction implements CaptureExceptionActionInterface
{
    public function __construct(
        protected SendEmailNotificationActionInterface $sendEmail,
        protected CreateExceptionLogActionInterface $createExceptionLog
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
