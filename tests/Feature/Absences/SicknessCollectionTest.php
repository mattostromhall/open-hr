<?php

use Domain\Absences\Models\Sickness;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;

test('it_calculates_the_number_of_days_taken_in_current_year', function () {
    $user = User::factory()->create();

    $person = Person::factory()
        ->for($user)
        ->create();

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
