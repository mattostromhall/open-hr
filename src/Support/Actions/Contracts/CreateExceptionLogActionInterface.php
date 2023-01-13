<?php

namespace Support\Actions\Contracts;

use Support\DataTransferObjects\ExceptionLogData;
use Support\Models\ExceptionLog;

interface CreateExceptionLogActionInterface
{
    public function execute(ExceptionLogData $data): ExceptionLog;
}
