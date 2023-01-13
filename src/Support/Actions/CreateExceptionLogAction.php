<?php

namespace Support\Actions;

use Illuminate\Support\Str;
use Support\Actions\Contracts\CreateExceptionLogActionInterface;
use Support\DataTransferObjects\ExceptionLogData;
use Support\Models\ExceptionLog;

class CreateExceptionLogAction implements CreateExceptionLogActionInterface
{
    public function execute(ExceptionLogData $data): ExceptionLog
    {
        return ExceptionLog::create([
            'hash' => $data->hash ?? Str::random(),
            'message' => $data->message,
            'stack_trace' => $data->stack_trace
        ]);
    }
}
