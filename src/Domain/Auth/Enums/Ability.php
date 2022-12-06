<?php

namespace Domain\Auth\Enums;

use Domain\Auth\DataTransferObjects\AbilityData;
use Illuminate\Support\Collection;
use Silber\Bouncer\BouncerFacade as Bouncer;

enum Ability: string
{
    case VIEW_HOLIDAY = 'view-holiday';
    case CREATE_HOLIDAY = 'create-holiday';
    case UPDATE_HOLIDAY = 'update-holiday';
    case DELETE_HOLIDAY = 'delete-holiday';
    case REVIEW_HOLIDAY = 'review-holiday';
    case VIEW_HOLIDAY_CALENDAR = 'view-holiday-calendar';
    case VIEW_SICKNESS = 'view-sickness';
    case CREATE_SICKNESS = 'create-sickness';
    case UPDATE_SICKNESS = 'update-sickness';
    case DELETE_SICKNESS = 'delete-sickness';
    case VIEW_USER = 'view-user';
    case CREATE_USER = 'create-user';
    case UPDATE_USER = 'update-user';
    case DELETE_USER = 'delete-user';
    case VIEW_EXPENSE = 'view-expense';
    case CREATE_EXPENSE = 'create-expense';
    case UPDATE_EXPENSE = 'update-expense';
    case DELETE_EXPENSE = 'delete-expense';
    case VIEW_EXPENSE_TYPE = 'view-expense-type';
    case CREATE_EXPENSE_TYPE = 'create-expense-type';
    case UPDATE_EXPENSE_TYPE = 'update-expense-type';
    case DELETE_EXPENSE_TYPE = 'delete-expense-type';
    case CREATE_DIRECTORY = 'create-folder';
    case DELETE_DIRECTORY = 'delete-folder';
    case UPLOAD_DOCUMENT = 'upload-document';
    case DOWNLOAD_DOCUMENT = 'download-document';
    case DELETE_DOCUMENT = 'delete-document';
    case CREATE_ORGANISATION_NOTIFICATION = 'create-organisation-notification';
    case UPDATE_ORGANISATION_NOTIFICATION = 'update-organisation-notification';
    case DELETE_ORGANISATION_NOTIFICATION = 'delete-organisation-notification';
    case CREATE_DEPARTMENT_NOTIFICATION = 'create-department-notification';
    case UPDATE_DEPARTMENT_NOTIFICATION = 'update-department-notification';
    case DELETE_DEPARTMENT_NOTIFICATION = 'delete-department-notification';
    case VIEW_DEPARTMENT = 'view-department';
    case CREATE_DEPARTMENT = 'create-department';
    case UPDATE_DEPARTMENT = 'update-department';
    case DELETE_DEPARTMENT = 'delete-department';
    case MANAGE_DEPARTMENT_MEMBERS = 'manage-department-members';
    case VIEW_ADDRESS = 'view-address';
    case CREATE_ADDRESS = 'create-address';
    case UPDATE_ADDRESS = 'update-address';
    case DELETE_ADDRESS = 'delete-address';
    case VIEW_PERSON = 'view-person';
    case VIEW_PEOPLE = 'view-people';
    case CREATE_PERSON = 'create-person';
    case UPDATE_PERSON = 'update-person';
    case DELETE_PERSON = 'delete-person';
    case MANAGE_DIRECT_REPORTS = 'manage-direct-reports';
    case VIEW_OBJECTIVE = 'view-objective';
    case CREATE_OBJECTIVE = 'create-objective';
    case UPDATE_OBJECTIVE = 'update-objective';
    case DELETE_OBJECTIVE = 'delete-objective';
    case COMPLETE_OBJECTIVE = 'complete-objective';
    case VIEW_ONE_TO_ONE = 'view-one-to-one';
    case CREATE_ONE_TO_ONE = 'create-one-to-one';
    case UPDATE_ONE_TO_ONE = 'update-one-to-one';
    case DELETE_ONE_TO_ONE = 'delete-one-to-one';
    case SCHEDULE_ONE_TO_ONE = 'schedule-one-to-one';
    case COMPLETE_ONE_TO_ONE = 'complete-one-to-one';
    case VIEW_TRAINING = 'view-training';
    case CREATE_TRAINING = 'create-training';
    case UPDATE_TRAINING = 'update-training';
    case DELETE_TRAINING = 'delete-training';
    case REVIEW_TRAINING = 'review-training';
    case COMPLETE_TRAINING = 'complete-training';
    case VIEW_TASK = 'view-task';
    case CREATE_TASK = 'create-task';
    case UPDATE_TASK = 'update-task';
    case DELETE_TASK = 'delete-task';
    case COMPLETE_TASK = 'complete-task';
    case VIEW_VACANCY = 'view-vacancy';
    case CREATE_VACANCY = 'create-vacancy';
    case UPDATE_VACANCY = 'update-vacancy';
    case DELETE_VACANCY = 'delete-vacancy';
    case VIEW_APPLICATION = 'view-application';
    case UPDATE_APPLICATION = 'update-application';
    case DELETE_APPLICATION = 'delete-application';
    case ASSIGN_ROLE = 'assign-role';
    case RETRACT_ROLE = 'retract-role';
    case ASSIGN_ABILITY = 'assign-ability';
    case RETRACT_ABILITY = 'retract-ability';

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
