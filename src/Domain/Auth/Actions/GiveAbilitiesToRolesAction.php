<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Actions\Contracts\GiveAbilitiesToRolesActionInterface;
use Domain\Auth\Enums\Role;
use Silber\Bouncer\Bouncer;

class GiveAbilitiesToRolesAction implements GiveAbilitiesToRolesActionInterface
{
    public function __construct(protected Bouncer $bouncer)
    {
        //
    }

    public function execute(): void
    {
        $this->bouncer->allow(Role::ADMIN->value)->everything();

        $this->bouncer->allow(Role::HEAD_OF_DEPARTMENT->value)->to(Role::HEAD_OF_DEPARTMENT->associatedAbilities());

        $this->bouncer->allow(Role::MANAGER->value)->to(Role::MANAGER->associatedAbilities());

        $this->bouncer->allow(Role::PERSON->value)->to(Role::PERSON->associatedAbilities());
    }
}
