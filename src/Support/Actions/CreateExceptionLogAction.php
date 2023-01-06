<?php

namespace Support\Actions;

use Illuminate\Support\Str;
use Support\DataTransferObjects\ExceptionLogData;
use Support\Models\ExceptionLog;

class CreateExceptionLogAction
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
