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

class StoreTrainingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'numeric'],
            'status' => ['required', new Enum(TrainingStatus::class)],
            'state' => ['required', new Enum(TrainingState::class)],
            'description' => ['required', 'string', 'min:2', 'max:255'],
            'provider' => ['required', 'string', 'min:2', 'max:255'],
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
                'person' => Person::find($this->validated('person_id')),
                'status' => TrainingStatus::from($this->validated('status')),
                'state' => TrainingState::from($this->validated('state')),
                'cost_currency' => $this->validated('cost_currency') ? Currency::from($this->validated('cost_currency')) : null
            ]
        );
    }
}
