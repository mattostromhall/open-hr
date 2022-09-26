<?php

namespace Database\Factories;

use Domain\Organisation\Models\Department;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'head_of_department_id' => Person::factory()
        ];
    }
}
