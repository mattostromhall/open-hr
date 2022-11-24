<?php

namespace Domain\Auth\Enums;

use Domain\Auth\DataTransferObjects\AbilityData;
use Illuminate\Support\Collection;
use Silber\Bouncer\BouncerFacade as Bouncer;

enum Ability: string
{
    case CREATE_USERS = 'create-users';
    case UPDATE_USERS = 'update-users';
    case DELETE_USERS = 'delete-users';
    case CREATE_EXPENSE_TYPES = 'create-expense-types';
    case UPDATE_EXPENSE_TYPES = 'update-expense-types';
    case DELETE_EXPENSE_TYPES = 'delete-expense-types';
    case UPLOAD_DOCUMENTS = 'upload-documents';
    case DOWNLOAD_DOCUMENTS = 'download-documents';
    case DELETE_DOCUMENTS = 'delete-documents';
    case CREATE_NOTIFICATIONS = 'create-notifications';
    case UPDATE_NOTIFICATIONS = 'update-notifications';
    case DELETE_NOTIFICATIONS = 'delete-notifications';
    case REVIEW_HOLIDAY = 'review-holiday';
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
