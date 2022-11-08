<?php

namespace App\Http\Performance\Requests;

use Domain\People\Models\Person;
use Domain\Performance\DataTransferObjects\TaskData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class StoreTaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'due_at' => ['required', 'date', 'after_or_equal:today']
        ];
    }

    public function taskData(): TaskData
    {
        return TaskData::from([
            'objective' => $this->objective,
            ...$this->safe()->all()
        ]);
    }
}
