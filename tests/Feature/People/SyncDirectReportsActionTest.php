<?php

use Domain\People\Actions\SyncDirectReportsAction;
use Domain\People\Models\Person;

it('adds direct reports to a person', function () {
    $people = Person::factory()
        ->count(4)
        ->create();
    $action = app(SyncDirectReportsAction::class);

    $action->execute($people->first(), $people->skip(1)->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('manager_id', $people->first()->id)
            ->count()
    )->toBe(3);
});

it('removes an already assigned direct report if no longer assigned', function () {
    $people = Person::factory()
        ->count(4)
        ->create();
    $action = app(SyncDirectReportsAction::class);

    $action->execute($people->first(), $people->skip(1)->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('manager_id', $people->first()->id)
            ->count()
    )->toBe(3);

    $action->execute($people->first(), $people->skip(2)->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('manager_id', $people->first()->id)
            ->count()
    )->toBe(2)
        ->and(
            Person::query()
                ->firstWhere('id', $people[1]->id)
                ->manager_id
        )->toBeNull();
});
