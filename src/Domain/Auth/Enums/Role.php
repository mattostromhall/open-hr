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
    case HEAD_OF_DEPARTMENT = 'head-of-department';
    case MANAGER = 'manager';
    case PERSON = 'person';

    public function associatedAbilities(): array
    {
        return match ($this) {
            self::ADMIN => ['*'],
            self::HEAD_OF_DEPARTMENT => [
                Ability::REVIEW_HOLIDAY->value,
                Ability::VIEW_HOLIDAY_CALENDAR->value,
                Ability::DELETE_SICKNESS->value,
                Ability::VIEW_USER->value,
                Ability::CREATE_USER->value,
                Ability::UPDATE_USER->value,
                Ability::CREATE_DEPARTMENT_NOTIFICATION->value,
                Ability::UPDATE_DEPARTMENT_NOTIFICATION->value,
                Ability::DELETE_DEPARTMENT_NOTIFICATION->value,
                Ability::VIEW_DEPARTMENT->value,
                Ability::UPDATE_DEPARTMENT->value,
                Ability::MANAGE_DEPARTMENT_MEMBERS->value,
                Ability::VIEW_PEOPLE->value,
                Ability::CREATE_PEOPLE->value,
                Ability::UPDATE_PEOPLE->value,
                Ability::CREATE_OBJECTIVE->value,
                Ability::UPDATE_OBJECTIVE->value,
                Ability::DELETE_OBJECTIVE->value,
                Ability::SCHEDULE_ONE_TO_ONE->value,
                Ability::REVIEW_TRAINING->value,
                Ability::CREATE_TASK->value,
                Ability::UPDATE_TASK->value,
                Ability::DELETE_TASK->value,
                Ability::COMPLETE_TASK->value,
                Ability::VIEW_VACANCY->value,
                Ability::CREATE_VACANCY->value,
                Ability::UPDATE_VACANCY->value,
                Ability::DELETE_VACANCY->value,
                Ability::VIEW_APPLICATION->value,
                Ability::UPDATE_APPLICATION->value,
                Ability::DELETE_APPLICATION->value,
                Ability::ASSIGN_ROLE->value,
                Ability::RETRACT_ROLE->value,
                Ability::ASSIGN_ABILITY->value,
                Ability::RETRACT_ABILITY->value
            ],
            self::MANAGER => [
                Ability::REVIEW_HOLIDAY->value,
                Ability::VIEW_HOLIDAY_CALENDAR->value,
                Ability::DELETE_SICKNESS->value,
                Ability::VIEW_USER->value,
                Ability::CREATE_USER->value,
                Ability::UPDATE_USER->value,
                Ability::VIEW_PEOPLE->value,
                Ability::CREATE_PEOPLE->value,
                Ability::UPDATE_PEOPLE->value,
                Ability::CREATE_OBJECTIVE->value,
                Ability::UPDATE_OBJECTIVE->value,
                Ability::DELETE_OBJECTIVE->value,
                Ability::SCHEDULE_ONE_TO_ONE->value,
                Ability::REVIEW_TRAINING->value,
                Ability::CREATE_TASK->value,
                Ability::UPDATE_TASK->value,
                Ability::DELETE_TASK->value,
                Ability::COMPLETE_TASK->value,
                Ability::VIEW_VACANCY->value,
                Ability::CREATE_VACANCY->value,
                Ability::UPDATE_VACANCY->value,
                Ability::DELETE_VACANCY->value,
                Ability::VIEW_APPLICATION->value,
                Ability::UPDATE_APPLICATION->value,
                Ability::DELETE_APPLICATION->value,
                Ability::ASSIGN_ROLE->value,
                Ability::RETRACT_ROLE->value,
                Ability::ASSIGN_ABILITY->value,
                Ability::RETRACT_ABILITY->value
            ],
            self::PERSON => [
                Ability::VIEW_HOLIDAY->value,
                Ability::CREATE_HOLIDAY->value,
                Ability::UPDATE_HOLIDAY->value,
                Ability::DELETE_HOLIDAY->value,
                Ability::VIEW_SICKNESS->value,
                Ability::CREATE_SICKNESS->value,
                Ability::UPDATE_SICKNESS->value,
                Ability::VIEW_USER->value,
                Ability::UPDATE_USER->value,
                Ability::VIEW_EXPENSE->value,
                Ability::CREATE_EXPENSE->value,
                Ability::UPDATE_EXPENSE->value,
                Ability::DELETE_EXPENSE->value,
                Ability::UPLOAD_DOCUMENT->value,
                Ability::DOWNLOAD_DOCUMENT->value,
                Ability::DELETE_DOCUMENT->value,
                Ability::VIEW_ADDRESS->value,
                Ability::CREATE_ADDRESS->value,
                Ability::UPDATE_ADDRESS->value,
                Ability::DELETE_ADDRESS->value,
                Ability::VIEW_PEOPLE->value,
                Ability::UPDATE_PEOPLE->value,
                Ability::VIEW_OBJECTIVE->value,
                Ability::COMPLETE_OBJECTIVE->value,
                Ability::VIEW_ONE_TO_ONE->value,
                Ability::CREATE_ONE_TO_ONE->value,
                Ability::UPDATE_ONE_TO_ONE->value,
                Ability::DELETE_ONE_TO_ONE->value,
                Ability::VIEW_TRAINING->value,
                Ability::CREATE_TRAINING->value,
                Ability::UPDATE_TRAINING->value,
                Ability::DELETE_TRAINING->value,
                Ability::VIEW_TASK->value,
                Ability::COMPLETE_TASK->value
            ]
        };
    }

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
