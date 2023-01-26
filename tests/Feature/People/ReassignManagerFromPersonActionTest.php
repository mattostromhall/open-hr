<?php

use Domain\People\Actions\ReassignManagerFromPersonAction;
use Domain\People\Models\Person;

it('reassigns the manager for the current managers direct reports', function () {
    $manager = Person::factory()->create();
    $newManager = Person::factory()->create();
    Person::factory()
        ->count(3)
        ->create([
            'manager_id' => $manager->id
        ]);

    expect(
        Person::query()
            ->where('manager_id', $manager->id)
            ->count()
    )->toBe(3);

    $action = app(ReassignManagerFromPersonAction::class);

    $action->execute($manager, $newManager->id);

    expect(
        Person::query()
            ->where('manager_id', $newManager->id)
            ->count()
    )->toBe(3);
});
