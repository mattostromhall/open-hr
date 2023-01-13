<?php

namespace Support\Actions\Contracts;

use Exception;
use Support\Models\ExceptionLog;

interface CaptureExceptionActionInterface
{
    public function execute(Exception $e): ExceptionLog;
}
