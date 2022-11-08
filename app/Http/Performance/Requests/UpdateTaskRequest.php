<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\DataTransferObjects\TaskData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class UpdateTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['string'],
            'due_at' => ['date'],
            'completed_at' => ['date', 'nullable']
        ];
    }

    public function taskData(): TaskData
    {
        return TaskData::from([
            'objective' => $this->task->objective,
            ...$this->safe()->all()
        ]);
    }

    public function validatedData(): array
    {
        return array_merge(
            $this->safe([
                'description'
            ]),
            [
                'objective' => $this->task->objective,
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
