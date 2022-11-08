<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\DataTransferObjects\ObjectiveData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreObjectiveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'person_id' => ['required', 'numeric'],
            'title' => ['required', 'string', 'min:2', 'max:256'],
            'description' => ['required', 'string'],
            'due_at' => ['required', 'date', 'after_or_equal:today']
        ];
    }

    public function objectiveData(): ObjectiveData
    {
        return ObjectiveData::from($this->safe()->all());
    }
}
