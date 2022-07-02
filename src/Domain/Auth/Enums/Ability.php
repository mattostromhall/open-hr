<?php

namespace Domain\Auth\Enums;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

enum Ability: string
{
    case REVIEW_HOLIDAY = 'review-holiday';
    case CREATE_ANNOUNCEMENTS = 'create-announcements';
    case ASSIGN_ROLES = 'assign-roles';
    case ASSIGN_ABILITIES = 'assign-abilities';

    public static function all(): Collection
    {
        return collect(self::cases())->map(fn ($case) => [
            'name' => $case->value,
            'title' => Str::of($case->value)->replace('-', ' ')->ucfirst()
        ]);
    }
}
