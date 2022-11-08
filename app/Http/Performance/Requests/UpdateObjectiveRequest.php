<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateObjectiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['string', 'min:2', 'max:256'],
            'description' => ['string'],
            'due_at' => ['date', 'after_or_equal:today'],
            'completed_at' => ['date', 'after_or_equal:due_at', 'nullable']
        ];
    }

    public function objectiveData(): ObjectiveData
    {
        return ObjectiveData::from([
            'person' => $this->objective->person,
            ...$this->objective->toArray(),
            ...$this->safe()->all()
        ]);
    }
}
