<?php

namespace Domain\Auth\Actions\Contracts;

use Domain\Auth\DataTransferObjects\RoleData;
use Domain\Auth\Enums\Role;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Silber\Bouncer\BouncerFacade as Bouncer;

interface CreateRolesActionInterface
{
    public function execute(): Collection;
}
