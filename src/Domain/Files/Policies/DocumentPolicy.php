<?php

namespace Domain\Files\Policies;

use Domain\Absences\Models\Sickness;
use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Expenses\Models\Expense;
use Domain\Files\Models\Document;
use Domain\Organisation\Models\Department;
use Domain\Organisation\Models\Organisation;
use Domain\People\Models\Person;
use Domain\Recruitment\Models\Application;
use Domain\Recruitment\Models\Vacancy;
use Illuminate\Auth\Access\HandlesAuthorization;

class DocumentPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->isAn(Role::ADMIN->value)) {
            return true;
        }

        return null;
    }

    public function upload(User $user): bool
    {
        return $user->can(Ability::UPLOAD_DOCUMENT->value);
    }

    public function download(User $user, Document $document): bool
    {
        $documentable = $document->documentable;

        return match (get_class($documentable)) {
            Sickness::class,
            Expense::class => $user->person->owns($documentable)
                || $user->person->isManagerFor($documentable)
                || $user->person->isHeadOfDepartmentFor($documentable),

            Organisation::class => true,

            Person::class => $user->person->owns($documentable, 'id')
                || $user->person->isManagerFor($documentable)
                || $user->person->isHeadOfDepartmentFor($documentable),

            Department::class => $documentable->hasMember($user->person),

            Vacancy::class => $user->can(Ability::VIEW_VACANCY->value),

            Application::class => $user->can(Ability::VIEW_APPLICATION->value)
        }
            && $user->can(Ability::DOWNLOAD_DOCUMENT->value);
    }

    public function delete(User $user, Document $document): bool
    {
        $documentable = $document->documentable;

        return match (get_class($documentable)) {
            Sickness::class,
            Expense::class => $user->person->owns($documentable)
                || $user->person->isManagerFor($documentable)
                || $user->person->isHeadOfDepartmentFor($documentable),

            Organisation::class => false,

            Person::class => $user->person->owns($documentable, 'id')
                || $user->person->isManagerFor($documentable)
                || $user->person->isHeadOfDepartmentFor($documentable),

            Department::class => $documentable->isHead($user->person),

            Vacancy::class => $user->can(Ability::DELETE_VACANCY->value),

            Application::class => $user->can(Ability::DELETE_APPLICATION->value)
        }
            && $user->can(Ability::DELETE_DOCUMENT->value);
    }
}
