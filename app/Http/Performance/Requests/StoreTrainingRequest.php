<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\Enums\OneToOneStatus;
use Domain\Performance\Enums\RecurrenceInterval;
use Domain\Performance\Enums\TrainingProgress;
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
            'progress' => ['required', new Enum(TrainingProgress::class)],
            'description' => ['required', 'string', 'min:2', 'max:255'],
            'provider' => ['required', 'string', 'min:2', 'max:255'],
            'location' => ['string', 'min:2', 'max:255', 'nullable'],
            'cost' => ['numeric', 'nullable'],
            'cost_currency' => ['numeric', 'nullable', 'required_if:cost'],
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
                'progress' => TrainingProgress::from($this->validated('progress')),
                'cost_currency' => Currency::from($this->validated('cost_currency'))
            ]
        );
    }
}
