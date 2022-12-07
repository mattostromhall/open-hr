<?php

namespace Database\Factories;

use Domain\Files\Enums\DocumentableType;
use Domain\People\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Support\Models\ActionLog;

class ActionLogFactory extends Factory
{
    protected $model = ActionLog::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
            'action' => 'CREATED',
            'actionable_id' => 1,
            'actionable_type' => 'objective'
        ];
    }
}
