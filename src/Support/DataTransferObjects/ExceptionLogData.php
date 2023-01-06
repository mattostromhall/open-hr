<?php

namespace Support\DataTransferObjects;

use Exception;
use Illuminate\Support\Str;

class ExceptionLogData extends DataTransferObject
{
    public function __construct(
        public readonly string $message,
        public readonly string $stack_trace,
        public readonly ?string $hash = null
    ) {
        //
    }

    public static function fromException(Exception $e): self
    {
        return new self(
            message: $e->getMessage(),
            stack_trace: $e->getTraceAsString(),
            hash: Str::random()
        );
    }
}
