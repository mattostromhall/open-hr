<?php

namespace Domain\Recruitment\Enums;

enum ApplicationStatus: int
{
    case PENDING = 1;
    case SUCCESSFUL = 2;
    case UNSUCCESSFUL = 3;

    public function statusDisplay(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::SUCCESSFUL => 'successful',
            self::UNSUCCESSFUL => 'unsuccessful'
        };
    }
}
