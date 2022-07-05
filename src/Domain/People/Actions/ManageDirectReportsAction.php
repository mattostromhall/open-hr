<?php

namespace Domain\People\Actions;

use Domain\Auth\Actions\AssignRoleAction;
use Domain\Auth\Actions\RetractRoleAction;
use Domain\Auth\Enums\Role;
use Domain\People\Models\Person;
use Illuminate\Support\Facades\DB;

class ManageDirectReportsAction
{
    public function __construct(
        protected AssignRoleAction $assignRole,
        protected RetractRoleAction $retractRole
    ) {
        //
    }

    public function execute(Person $person, array $people): void
    {
        DB::transaction(function () use ($person, $people) {
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
        });
    }
}
