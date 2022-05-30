<?php

namespace Support\Exceptions;

use Exception;

class InvalidPeriodDatesException extends Exception
{
    public static function because(string $message): self
    {
        return new self($message);
    }
}
