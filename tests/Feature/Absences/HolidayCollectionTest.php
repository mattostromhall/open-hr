<?php

use Domain\Absences\Enums\HalfDay;
use Domain\Absences\Models\Holiday;
use Domain\Auth\Models\User;
use Domain\People\Models\Person;

test('it calculates the number of days taken in current year', function () {
    $person = Person::factory()->create();

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
    )->toBe(5.5);
});
