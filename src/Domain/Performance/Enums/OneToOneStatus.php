<?php

namespace Domain\Performance\Enums;

enum OneToOneStatus: int
{
    case INVITED = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;

    public function statusDisplay(): string
    {
        return match ($this) {
            self::INVITED => 'invited',
            self::ACCEPTED => 'accepted',
            self::REJECTED => 'rejected',
        };
    }
}
