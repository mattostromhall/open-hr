<?php

namespace Database\Factories;

use Domain\Files\Enums\DocumentableType;
use Domain\Files\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(50),
            'directory' => '/test',
            'size' => $this->faker->numberBetween(1, 1024),
            'extension' => $this->faker->fileExtension(),
            'disk' => 'local',
            'documentable_id' => 1,
            'documentable_type' => DocumentableType::PERSON
        ];
    }
}
