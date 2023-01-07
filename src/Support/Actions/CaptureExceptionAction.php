<?php

namespace Support\Actions;

use Exception;
use Support\DataTransferObjects\ExceptionLogData;
use Support\Models\ExceptionLog;

class CaptureExceptionAction
{
    public function __construct(protected CreateExceptionLogAction $createExceptionLog)
    {
        //
    }

    /**
     * @throws Exception
     */
    public function execute(Exception $e): ExceptionLog
    {
//        if (! app()->environment('production')) {
//            throw $e;
//        }

        return $this->createExceptionLog->execute(ExceptionLogData::fromException($e));
    }
}
