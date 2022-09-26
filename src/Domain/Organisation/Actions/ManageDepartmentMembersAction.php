<?php

namespace Domain\Organisation\Actions;

use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Illuminate\Support\Facades\DB;

class ManageDepartmentMembersAction
{
    public function execute(Department $department, array $people): void
    {
        DB::transaction(function () use ($department, $people) {
            Person::query()
            ->whereIn('id', $people)
            ->update([
                'department_id' => $department->id
            ]);

            Person::query()
            ->whereNotIn('id', $people)
            ->where('department_id', $department->id)
            ->update([
                'department_id' => null
            ]);
        });
    }
}
