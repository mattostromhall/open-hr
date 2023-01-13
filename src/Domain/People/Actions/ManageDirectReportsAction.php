<?php

namespace Domain\People\Actions;

use Domain\Auth\Actions\Contracts\AssignRoleActionInterface;
use Domain\Auth\Actions\Contracts\RetractRoleActionInterface;
use Domain\Auth\Enums\Role;
use Domain\People\Actions\Contracts\ManageDirectReportsActionInterface;
use Domain\People\Models\Person;

class ManageDirectReportsAction implements ManageDirectReportsActionInterface
{
    public function __construct(
        protected AssignRoleActionInterface $assignRole,
        protected RetractRoleActionInterface $retractRole
    ) {
        //
    }

    public function execute(Person $person, array $people): void
    {
        Person::query()
        ->whereIn('id', $people)
        ->update([
            'manager_id' => $person->id
        ]);

        Person::query()
        ->whereNotIn('id', $people)
        ->where('manager_id', $person->id)
        ->update([
            'manager_id' => null
        ]);

        count($people) > 0
            ? $this->assignRole->execute($person->user, Role::MANAGER)
            : $this->retractRole->execute($person->user, Role::MANAGER);
    }
}
