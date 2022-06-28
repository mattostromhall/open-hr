<?php

namespace Domain\People\Actions;

use Domain\People\Models\Person;
use Illuminate\Support\Facades\DB;

class SyncDirectReportsAction
{
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
        });
    }
}
