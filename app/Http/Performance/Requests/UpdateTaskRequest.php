<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['string'],
            'due_at' => ['date', 'after_or_equal:today'],
            'completed_at' => ['date', 'after_or_equal:due_at', 'nullable']
        ];
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'description'
            ]),
            [
                'person' => $this->task->objective,
                'due_at' => $this->validated('due_at') ? Carbon::parse($this->validated('due_at')) : null,
                'completed_at' => $this->validated('completed_at') ? Carbon::parse($this->validated('completed_at')) : null
            ]
        );
    }

    public function filteredValidatedData(): array
    {
        return array_filter($this->validatedData());
    }
}
