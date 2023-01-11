<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\SyncRolesActionInterface;
use Domain\Auth\Models\User;
use Silber\Bouncer\BouncerFacade as Bouncer;

class SyncRolesAction implements SyncRolesActionInterface
{
    public function execute(User $user, array $roles): void
    {
        Bouncer::sync($user)->roles($roles);
    }
}
