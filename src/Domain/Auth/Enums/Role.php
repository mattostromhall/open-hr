<?php

namespace Domain\Auth\Enums;

use Domain\Auth\DataTransferObjects\RoleData;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Role: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case PERSON = 'person';

    public static function all(): Collection
    {
        return collect(self::cases())->map(
            fn ($case) => new RoleData(
                name: $case->value,
                title: Str::of($case->value)->replace('-', ' ')->ucfirst()
            )
        );
    }
}
