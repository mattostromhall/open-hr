<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\DataTransferObjects\TrainingData;
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

    public function trainingData(): TrainingData
    {
        return TrainingData::from($this->safe()->all());
    }

    public function flashMessage(): string
    {
        return $this->validated('person_id') === person()->id
            ? 'Training request submitted!'
            : 'Training assigned!';
    }
}
