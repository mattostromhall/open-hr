<?php

namespace Database\Factories;

use Domain\Notifications\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->text(),
            'body' => $this->faker->text(),
            'link' => $this->faker->url(),
            'read' => false
        ];
    }
}
