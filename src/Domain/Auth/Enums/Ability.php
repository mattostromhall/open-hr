<?php

namespace Domain\Auth\Enums;

use Domain\Auth\DataTransferObjects\AbilityData;
use Illuminate\Support\Collection;
use Silber\Bouncer\BouncerFacade as Bouncer;

enum Ability: string
{
    case REVIEW_HOLIDAY = 'review-holiday';
    case CREATE_ANNOUNCEMENTS = 'create-announcements';
    case ASSIGN_ROLES = 'assign-roles';
    case ASSIGN_ABILITIES = 'assign-abilities';

    public static function values(): Collection
    {
        return collect(self::cases())->map(fn ($role) => $role->value);
    }

    public static function all(): Collection
    {
        return Bouncer::ability()
            ->whereIn('name', self::values())
            ->get()
            ->map(
                fn ($ability) => new AbilityData(
                    name: $ability->name,
                    title: $ability->title
                )
            );
    }
}
