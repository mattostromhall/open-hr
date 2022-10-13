<?php

namespace Database\Factories;

use Domain\Absences\Enums\HolidayStatus;
use Domain\Absences\Models\Holiday;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class HolidayFactory extends Factory
{
    protected $model = Holiday::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'status' => HolidayStatus::APPROVED,
            'start_at' => now(),
            'finish_at' => now()->addDays(6)
        ];
    }
}
