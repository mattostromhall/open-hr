<?php

use Domain\People\Actions\ManageDirectReportsAction;
use Domain\People\Models\Person;

it('adds direct reports to a person and the manager role', function () {
    $people = Person::factory()
        ->count(4)
        ->create();
    $action = app(ManageDirectReportsAction::class);

    $action->execute($people->first(), $people->skip(1)->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('manager_id', $people->first()->id)
            ->count()
    )->toBe(3)
        ->and(
            $people->first()->user->isA('manager')
        )->toBeTrue();

});

it('removes an already assigned direct report if no longer assigned', function () {
    $people = Person::factory()
        ->count(4)
        ->create();
    $action = app(ManageDirectReportsAction::class);

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

it('removes all assigned direct reports and the manager role', function () {
    $people = Person::factory()
        ->count(4)
        ->create();
    $action = app(ManageDirectReportsAction::class);

    $action->execute($people->first(), $people->skip(1)->pluck('id')->toArray());

    expect(
        Person::query()
            ->where('manager_id', $people->first()->id)
            ->count()
    )->toBe(3);

    $action->execute($people->first(), []);

    expect(
        Person::query()
            ->where('manager_id', $people->first()->id)
            ->count()
    )->toBe(0)
        ->and(
            $people->first()->user->isA('manager')
        )->toBeFalse();
});
