<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\Enums\TrainingState;
use Domain\Performance\Enums\TrainingStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;
use Support\Enums\Currency;

class UpdateTrainingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => [new Enum(TrainingStatus::class)],
            'state' => [new Enum(TrainingState::class)],
            'description' => ['string', 'min:2', 'max:255'],
            'provider' => ['string', 'min:2', 'max:255'],
            'location' => ['string', 'min:2', 'max:255', 'nullable'],
            'cost' => ['numeric', 'nullable'],
            'cost_currency' => [new Enum(Currency::class), 'nullable', 'required_with:cost'],
            'duration' => ['numeric', 'nullable'],
            'notes' => ['string', 'nullable']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'description',
                'provider',
                'location',
                'cost',
                'duration',
                'notes'
            ]),
            [
                'person' => $this->training->person,
                'status' => $this->validated('status') ? TrainingStatus::from($this->validated('status')) : null,
                'state' => $this->validated('state') ? TrainingState::from($this->validated('state')) : null,
                'cost_currency' => $this->validated('cost_currency') ? Currency::from($this->validated('cost_currency')) : null
            ]
        );
    }

    public function filteredValidatedData(): array
    {
        return array_filter($this->validatedData());
    }
}
