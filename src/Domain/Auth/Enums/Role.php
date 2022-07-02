<?php

namespace Domain\Auth\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Role: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case PERSON = 'person';

    public static function all(): Collection
    {
        return collect(self::cases())->map(fn ($case) => [
            'name' => Str::of($case->value)->replace('-', ' ')->ucfirst(),
            'title' => $case->value
        ]);
    }
}
