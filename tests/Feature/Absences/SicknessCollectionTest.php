<?php

use Domain\Absences\Models\Sickness;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;

test('it calculates the number of days taken in current year', function () {
    $person = Person::factory()->create();

    Sickness::factory()
        ->for($person)
        ->count(3)
        ->create();

    expect(
        $person->sicknessThisYear()
            ->get()
            ->numberTaken()
    )->toBe(6);
});
