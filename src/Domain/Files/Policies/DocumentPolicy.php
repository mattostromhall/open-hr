<?php

namespace Domain\Files\Policies;

use Domain\Auth\Enums\Ability;
use Domain\Auth\Enums\Role;
use Domain\Auth\Models\User;
use Domain\Files\Models\Document;
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
        return $user->can(Ability::DOWNLOAD_DOCUMENT->value);
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->can(Ability::DELETE_DOCUMENT->value);
    }
}
