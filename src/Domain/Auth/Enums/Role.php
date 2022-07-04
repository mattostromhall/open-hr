<?php

namespace Domain\Auth\Enums;

use Domain\Auth\DataTransferObjects\AbilityData;
use Domain\Auth\DataTransferObjects\RoleData;
use Illuminate\Support\Collection;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Silber\Bouncer\Database\Role as BouncerRole;

enum Role: string
{
    case ADMIN = 'admin';
    case MANAGER = 'manager';
    case PERSON = 'person';

    public static function values(): Collection
    {
        return collect(self::cases())->map(fn ($role) => $role->value);
    }

    public static function all(): Collection
    {
        return Bouncer::role()
            ->whereIn('name', self::values())
            ->get()
            ->map(
                fn ($role) => new RoleData(
                    name: $role->name,
                    title: $role->title,
                    abilities: self::abilities($role)
                )
            );
    }

    public static function abilities(BouncerRole $role): Collection
    {
        return $role->getAbilities()->map(
            fn ($ability) => new AbilityData(
                name: $ability->name,
                title: $ability->title
            )
        );
    }
}
