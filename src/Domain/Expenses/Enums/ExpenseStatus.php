<?php

namespace Domain\Expenses\Enums;

enum ExpenseStatus: int
{
    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;

    public function statusDisplay(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::APPROVED => 'approved',
            self::REJECTED => 'rejected',
        };
    }
}
