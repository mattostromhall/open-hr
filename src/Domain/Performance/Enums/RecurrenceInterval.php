<?php

namespace Domain\Performance\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum RecurrenceInterval: string
{
    case NEVER = 'never';
    case WEEKLY = 'weekly';
    case FORTNIGHTLY = 'fortnightly';
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case BIANNUALLY = 'biannually';

    public static function all(): Collection
    {
        return collect(self::cases())
            ->map(fn (self $interval) => [
                'value' => $interval->value,
                'display' => Str::ucfirst($interval->value)
            ]);
    }
}
