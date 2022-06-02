<?php

use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Models\Holiday;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;

test('it_calculates_the_number_of_days_taken_in_current_year', function () {
    $user = User::factory()->create();

    $person = Person::factory()
        ->for($user)
        ->create();

    Holiday::factory()
        ->for($person)
        ->create();

    Holiday::factory()
        ->for($person)
        ->create([
            'half_day' => HalfDay::AM,
            'finish_at' => now()
        ]);

    expect(
        $person->holidayThisYear()
            ->get()
            ->numberTaken()
    )->toBe(7.5);
});
